<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";

    $server = 'mysql:host=localhost:8889;dbname=inventory_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CategoryTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
          Category::deleteAll();
        }

        function testGetName()
        {
            //Arrange
            $name = "Romance";
            $test_category = new Category($name);

            //Act
            $result = $test_category->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

       function testSave()
        {
            //Arrange
            $name = "Romance";
            $test_category = new Category($name);

            //Act
            $executed = $test_category->save();

            // Assert
            $this->assertTrue($executed, "Category not successfully saved to database");
        }

        function testGetId()
        {
            //Arrange
            $name = "Romance";
            $test_category = new Category($name);
            $test_category->save();

            //Act
            $result = $test_category->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function testGetAll()
        {
            //Arrange
            $name = "Romance";
            $name_2 = "Science Fiction";
            $test_category = new Category($name);
            $test_category->save();
            $test_category_2 = new Category($name_2);
            $test_category_2->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals([$test_category, $test_category_2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "The Little Prince";
            $name_2 = "Science Fiction";
            $test_category = new Category($name);
            $test_category->save();
            $test_category_2 = new Category($name_2);
            $test_category_2->save();

            //Act
            Category::deleteAll();
            $result = Category::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $name = "The Little Prince";
            $name2 = "Science Fiction";
            $test_category = new Category($name);
            $test_category->save();
            $test_category_2 = new Category($name2);
            $test_category_2->save();

            //Act
            $result = Category::find($test_category->getId());

            //Assert
            $this->assertEquals($test_category, $result);
        }
    }

?>
