<?php

    class Checkout
    {
        private $patron_id;
        private $copy_id;
        private $checkout_date;
        private $due_date;
        private $id;

        function __construct($patron_id, $copy_id, $checkout_date, $due_date, $id = null)
        {
            $this->patron_id = $patron_id;
            $this->copy_id = $copy_id;
            $this->checkout_date = $checkout_date;
            $this->due_date = $due_date;
            $this->id = $id;
        }
        function getId()
        {
            return $this->id;
        }
        function getPatronId()
        {
            return $this->patron_id;
        }

        function setPatronId($new_patron_id)
        {
            $this->patron_id = $new_patron_id;
        }

        function getCopyId()
        {
            return $this->copy_id;
        }

        function setCopyId($new_copy_id)
        {
            $this->copy_id = $new_copy_id;
        }

        function getCheckoutDate()
        {
            return $this->checkout_date;
        }

        function setCheckoutDate($new_checkout_date)
        {
            $this->checkout_date = $new_checkout_date;
        }

        function getDueDate()
        {
            return $this->due_date;
        }

        function setDueDate($new_due_date)
        {
            $this->due_date = $new_due_date;
        }

        function save()
        {
            $GLOBALS['DB']->exec(
                "INSERT INTO checkouts (patron_id, copy_id, checkout_date, due_date) VALUES(
                    {$this->getPatronId()},
                    {$this->getCopyId()},
                    '{$this->getCheckoutDate()}',
                    '{$this->getDueDate()}'
                );"
            );
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $checkouts_query = $GLOBALS['DB']->query("SELECT * FROM checkouts;");
            $all_checkouts = array();
            foreach ($checkouts_query as $checkout) {
                $patron_id = $checkout['patron_id'];
                $copy_id = $checkout['copy_id'];
                $checkout_date = $checkout['checkout_date'];
                $due_date = $checkout['due_date'];
                $id = $checkout['id'];
                $new_checkout = new Checkout($patron_id, $copy_id, $checkout_date, $due_date, $id);
                array_push($all_checkouts, $new_checkout);
            }
            return $all_checkouts;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM checkouts;");
        }

        static function find($search_id)
        {
         $found_checkout = null;
         $all_checkouts = Checkout::getAll();
         foreach ($all_checkouts as $checkout) {
             if ($checkout->getId() == $search_id) {
                 $found_checkout = $checkout;
             }
         }
         return $found_checkout;
        }

        function update($new_due_date)
        {
            $GLOBALS['DB']->exec("UPDATE checkouts SET due_date = '{$new_due_date}' where id = {$this->getId()};");
            $this->setDueDate($new_due_date);
        }




    }

?>
