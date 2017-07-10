<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Inventory.php";
    require_once __DIR__."/../src/Category.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=inventory';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/books", function() use ($app) {
        return $app['twig']->render('books.html.twig', array('books' => Inventory::getAll()));
    });

    $app->get("/categories", function() use ($app) {
        return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
    });

    $app->post("/categories", function() use ($app) {
        $category = new Category($_POST['name']);
        $category->save();
        return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
    });

    $app->post("/books", function() use ($app) {
        $book = $_POST['book'];
        $category_id = $_POST['category_id'];
        $inventory = new Inventory($book, $category_id, $id = null);
        $inventory->save();
        $category = Category::find($category_id);
        return $app['twig']->render('category.html.twig', array('category' => $category, 'inventories'->getInventories()));
    });

    $app->post("/delete_inventory", function() use ($app) {
        Inventory::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->post("/delete_categories", function() use ($app) {
        Category::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    return $app;
?>
