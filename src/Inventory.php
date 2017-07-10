<?php
    class Inventory
    {
        private $book;

        function __construct($book)
        {
            $this->book = $book;
        }
        function setBook($new_book)
        {
            $this->book = (string) $new_book;
        }

        function getBook()
        {
            return $this->book;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO inventories (book) VALUES ('{$this->getBook()}');");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }
    }
?>
