<?php

        /**
        * @backupGlobals disabled
        * @backupStatic Attributes disabled
        */

        require_once "src/Patron.php";

        $server = 'mysql:host=localhost;dbname=library_test';
        $username = 'root';
        $password = 'root';
        $DB = new PDO($server, $username, $password);

        class PatronTest extends PHPUnit_Framework_TestCase
        {
            protected function tearDown()
            {
                Patron::deleteAll();
            }

            function testSave()
            {
                //Arrange
                $id = null;
                $name = 'Phil';
                $phone = '8675309';
                $test_patron = new Patron($id, $name, $phone);

                //Act
                $test_patron->save();

                //Assert
                $result = Patron::getAll();
                $this->assertEquals([$test_patron], $result);
            }
        }






?>
