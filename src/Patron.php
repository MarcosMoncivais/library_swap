<?php

    class Patron
    {
        private $name;
        private $phone;
        private $id;

        function __construct($name, $phone, $id = null)
        {
            $this->name = $name;
            $this->phone = $phone;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function getPhone()
        {
            return $this->phone;
        }

        function getId()
        {
            return $this->id;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function setPhone($new_phone)
        {
            $this->phone = $new_phone;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO patrons (name, phone) VALUES ('{$this->getName()}', '{$this->getPhone()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $patrons_query = $GLOBALS['DB']->query("SELECT * FROM patrons;");
            $all_patrons = array();
            foreach ($patrons_query as $patron) {
                $name = $patron['name'];
                $phone = $patron['phone'];
                $id = $patron['id'];
                $new_patron = new Patron($name, $phone, $id);
                array_push($all_patrons, $new_patron);
            }
            return $all_patrons;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons;");
        }

        static function find($search_id)
        {
            $found_patron = null;
            $all_patrons = Patron::getAll();
            foreach ($all_patrons as $patron) {
                if ($patron->getId() == $search_id) {
                    $found_patron = $patron;
                }
            }
            return $found_patron;
        }

        function update($field, $new_value)
        {
            $GLOBALS['DB']->exec("UPDATE patrons SET {$field} = '{$new_value}' WHERE id = {$this->getId()};");
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
        }
    }
?>
