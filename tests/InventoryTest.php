<?php



    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Inventory.php";

    $server = 'mysql:host=localhost:8889;dbname=inventory_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class InventoryTest extends PHPUnit_Framework_TestCase
    {
        function test_save()
        {
            $book = "The Little Prince";
            $test_inventory = new Inventory($book);

            $executed = $test_inventory->save();

            $this->assertTrue($executed, "Book successfully saved to database");
        }

        function testGetAll()
        {
            //Arrange
            $book = "The Little Prince";
            $book_2 = "The Master and Margaritta";
            $test_inventory = new Task($book);
            $test_inventory->save();
            $test_inventory_2 = new Task($book_2);
            $test_inventory_2->save();

            //Act
            $result = Task::getAll();

            //Assert
            $this->assertEquals([$test_inventory, $test_inventory_2], $result);
  }
    }
?>
