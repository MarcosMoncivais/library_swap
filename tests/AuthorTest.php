<?php

    /**
    * @backupGlobals disabled
    * @backupStatic Attributes disabled
    */
    require_once "src/Author.php";
    require_once "src/Book.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Author::deleteAll();
            Book::deleteAll();
        }

        function testGetName()
        {
            //Arrange
            $name = "J.K. Rowling";
            $test_author = new Author($name);
            //Act
            $result = $test_author->getName();
            //Assert
            $this->assertEquals($name, $result);
        }

        //save test
        function testSave()
        {
            //Arrange
            $name = "C.S. Lewis";
            $test_author = new Author($name);
            $test_author->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals($test_author, $result[0]);
        }

        //getall test
        function testGetAll()
        {
            //Arrange
            $name = "J.K. Rowling";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "C.S. Lewis";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        //delete all test
        function testDeleteAll()
        {
            //Arrange
            $name = "J.K. Rowling";
            $test_author = new Author($name);
            $test_author->save();
            $name2 = "C.S. Lewis";
            $test_author2 = new Author($name2);
            $test_author2->save();
            //Act
            Author::deleteAll();

            //Assert
            $result = Author::getAll();
            $this->assertEquals([], $result);
        }

        function testUpdate()
        {
            //Arrange
            $name = "J.K. Rowling";
            $test_author = new Author($name);
            $test_author->save();
            //Act
            $new_name = "Boring Normal Chemistry";
            $test_author->update($new_name);
            //Assert
            $result = Author::getAll();
            $this->assertEquals($new_name, $result[0]->getName());
        }

        function testFind()
        {
            //Arrange
            $name = "J.K. Rowling";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "C.S. Lewis";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            $result = Author::find($test_author->getId());

            //Assert
            $this->assertEquals($test_author, $result);
        }

        function testDelete()
        {
            //Arrange
            $name = "J.K. Rowling";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "C.S. Lewis";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            $test_author->delete();
            $result = Author::getAll();

            //Assert
            $this->assertEquals($test_author2, $result[0]);
        }

        function testAddBook()
        {
            //Arrange
            $test_author = new Author("J.K. Rowling");
            $test_author->save();

            $test_book = new Book("Harry Potter and the Dish Stone", "Non-fiction");
            $test_book->save();

            //Act
            $test_author->addBook($test_book);

            //Assert
            $this->assertEquals($test_author->getBooks(), [$test_book]);
        }

        function testGetBooks()
        {
            //Arrange
            $test_author = new Author("J.K. Rowling");
            $test_author->save();

            $test_author2 = new Author("Harry Potter");
            $test_author2->save();

            $test_book = new Book("Harry Potter and the Dish Stone", "Non-fiction");
            $test_book->save();

            $test_book2 = new Book("Kelli Potter and the Three Bananas", "Fanasty");
            $test_book2->save();

            //Act
            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);
            $test_author2->addBook($test_book);

            //Assert
            $this->assertEquals($test_author->getBooks(), [$test_book, $test_book2]);
        }
    }

?>
