<?php
    class Inventory
    {
        private $book;
        private $id;

        function __construct($book, $id =null)
        {
            $this->book = $book;
            $this->id = $id;
        }
        function setBook($new_book)
        {
            $this->book = (string) $new_book;
        }

        function getBook()
        {
            return $this->book;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO inventories (book) VALUES ('{$this->getBook()}');");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        static function getAll()
        {
            $returned_inventories = $GLOBALS['DB']->query("SELECT * FROM inventories;");
            $inventories = array();
            foreach($returned_inventories as $inventory) {
                $book = $inventory['book'];
                $id = $inventory['id'];
                $new_inventory = new Inventory($book, $id);
                array_push($inventories, $new_inventory);
            }
                return $inventories;
        }

        static function deleteAll()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM inventories;");
            if ($executed) {
            return true;
            } else {
            return false;
            }
        }

        static function find($search_id)
        {
            $returned_inventories = $GLOBALS['DB']->prepare("SELECT * FROM inventories WHERE id = :id");
            $returned_inventories->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_inventories->execute();
            foreach ($returned_inventories as $inventory) {
               $inventory_book = $inventory['book'];
               $inventory_id = $inventory['id'];
               if ($inventory_id == $search_id) {
                  $found_inventory = new Inventory($inventory_book, $inventory_id);
               }
            }
                return $found_inventory;
        }
    }
?>
