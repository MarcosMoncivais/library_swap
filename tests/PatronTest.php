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
                $test_patron = new Patron($name, $phone, $id);

                //Act
                $test_patron->save();

                //Assert
                $result = Patron::getAll();
                $this->assertEquals([$test_patron], $result);
            }

            function testGetAll()
            {
                //Arrange
                $id =null;
                $name = 'Phil';
                $phone = '8675309';
                $test_patron = new Patron($name, $phone, $id);
                $test_patron->save();

                $name2 = 'Marcos';
                $phone2= '7777777';
                $test_patron2 = new Patron($name2, $phone2, $id);
                $test_patron2->save();

                //Act
                $result = Patron::getAll();

                //Assert
                $this->assertEquals([$test_patron, $test_patron2], $result);
            }

            function testDeleteAll()
            {
                //Arrange
                $id = null;
                $name = 'Phil';
                $phone = '8675309';
                $test_patron = new Patron($name, $phone, $id);
                $test_patron->save();

                $name2 = 'Marcos';
                $phone2 = '7777777';
                $test_patron2 = new Patron($name2, $phone2, $id);
                $test_patron2->save();

                //Act
                Patron::deleteAll();

                //Assert
                $result = Patron::getAll();
                $this->assertEquals([], $result);
            }

            function testFind()
            {
                //Arrange
                $id = null;
                $name = 'Phil';
                $phone = '8675309';
                $test_patron = new Patron($name, $phone, $id);
                $test_patron->save();

                $name2 = 'Marcos';
                $phone2 = '7777777';
                $test_patron2 = new Patron($name2, $phone2, $id);
                $test_patron2->save();

                //Act
                $result = Patron::find($test_patron->getId());

                //Assert
                $this->assertEquals($test_patron, $result);
            }

            function testUpdate()
            {
                //Arrage
                $id = null;
                $name = 'Phil';
                $phone = '8675309';
                $test_patron = new Patron($name, $phone, $id);
                $test_patron->save();

                $new_name = "Marcos";
                $new_phone = '7777777';

                //Act
                $test_patron->update('name', $new_name);
                $test_patron->update('phone', $new_phone);

                //Assert
                $result = Patron::getAll();
                $this->assertEquals([$result[0]->getName(), $result[0]->getPhone()], [$new_name, $new_phone]);

            }
        }






?>
