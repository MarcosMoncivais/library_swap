<?php

    /**
    * @backupGlobals disabled
    * @backupStatic Attributes disabled
    */

    require_once "src/Checkout.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CheckoutTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Checkout::deleteAll();
        }

        function testSave()
        {
            //Arrange
            $patron_id = 1;
            $copy_id = 2;
            $checkout_date = '2015-08-10';
            $due_date = '2015-08-24';
            $id = null;
            $test_checkout = new Checkout($patron_id, $copy_id, $checkout_date, $due_date, $id);

            //Act
            $test_checkout->save();

            //Assert
            $result = Checkout::getAll();
            $this->assertEquals([$test_checkout], $result);
        }

        function testGetAll()
        {
            //Arrange
            $patron_id = 1;
            $copy_id = 2;
            $checkout_date = '2015-08-10';
            $due_date = '2015-08-24';
            $id = null;
            $test_checkout = new Checkout($patron_id, $copy_id, $checkout_date, $due_date, $id);
            $test_checkout->save();

            $patron_id2 = 2;
            $copy_id2 = 1;
            $checkout_date2 = '2015-08-09';
            $due_date2 = '2015-08-23';
            $test_checkout2 = new Checkout($patron_id2, $copy_id2, $checkout_date2, $due_date2, $id);
            $test_checkout2->save();

            //Act
            $result = Checkout::getAll();

            //Assert
            $this->assertEquals([$test_checkout, $test_checkout2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $patron_id = 1;
            $copy_id = 2;
            $checkout_date = '2015-08-10';
            $due_date = '2015-08-24';
            $id = null;
            $test_checkout = new Checkout($patron_id, $copy_id, $checkout_date, $due_date, $id);
            $test_checkout->save();

            $patron_id2 = 2;
            $copy_id2 = 1;
            $checkout_date2 = '2015-08-09';
            $due_date2 = '2015-08-23';
            $test_checkout2 = new Checkout($patron_id2, $copy_id2, $checkout_date2, $due_date2, $id);
            $test_checkout2->save();

            //Act
            Checkout::deleteAll();

            //Assert
            $result = Checkout::getAll();
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $patron_id = 1;
            $copy_id = 2;
            $checkout_date = '2015-08-10';
            $due_date = '2015-08-24';
            $id = null;
            $test_checkout = new Checkout($patron_id, $copy_id, $checkout_date, $due_date, $id);
            $test_checkout->save();

            $patron_id2 = 2;
            $copy_id2 = 1;
            $checkout_date2 = '2015-08-09';
            $due_date2 = '2015-08-23';
            $test_checkout2 = new Checkout($patron_id2, $copy_id2, $checkout_date2, $due_date2, $id);
            $test_checkout2->save();

            //Act
            $result = Checkout::find($test_checkout->getId());

            //Assert
            $this->assertEquals($test_checkout, $result);
        }

        function testUpdate()
        {
            //Arrange
            $patron_id = 1;
            $copy_id = 2;
            $checkout_date = '2015-08-10';
            $due_date = '2015-08-24';
            $id = null;
            $test_checkout = new Checkout($patron_id, $copy_id, $checkout_date, $due_date, $id);
            $test_checkout->save();

            //Act
            $new_due_date = '2015-08-20';
            $test_checkout->update($new_due_date);

            //Assert
            $result = $test_checkout->getDueDate();
            $this->assertEquals($new_due_date, $result);        }

        }

?>
