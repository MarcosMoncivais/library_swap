<?php

    /**
    * @backupGlobals disabled
    * @backupStatic Attributes disabled
    */

    require_once "src/Book.php";
    require_once "src/Author.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
        }

        function test_getTitle()
        {
            //Arrange
            $title = "World War Z";
            // very new book
            $genre = "Horror";
            $test_book = new Book($title, $genre);

            //Act
            $result = $test_book->getTitle();

            //Assert
            $this->assertEquals($title, $result);
        }

        function test_getGenre()
        {
            //Arrange
            $title = "World War Z";
            $genre = "Horror";
            $test_book = new Book($title, $genre);

            //Act
            $result = $test_book->getGenre();

            //Assert
            $this->assertEquals($genre, $result);
        }

        function test_save()
        {
            //Arrange
            $title = "World War Z";
            $genre = "Horror";
            $test_book = new Book($title, $genre);

            //Act
            $test_book->save();

            //Assert
            $result = Book::getAll();
            $this->assertEquals($test_book, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $title = "World War Z";
            $genre = "Horror";
            $test_book = new Book($title, $genre);
            $test_book->save();

            $name2 = "Billy Bartle-Barnaby";
            $enroll_date2 = "2015-07-09";
            $test_book2 = new Book($name2, $enroll_date2);
            $test_book2->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $title = "World War Z";
            $genre = "Horror";
            $test_book = new Book($title, $genre);
            $test_book->save();

            $name2 = "Billy Bartle-Barnaby";
            $enroll_date2 = "2015-07-09";
            $test_book2 = new Book($name2, $enroll_date2);
            $test_book2->save();

            //Act
            Book::deleteAll();

            //Assert
            $result = Book::getAll();
            $this->assertEquals([], $result);
        }

        // test find
        function test_find()
        {
            //Arrange
            $title = "World War Z";
            $genre = "Horror";
            $test_book = new Book($title, $genre);
            $test_book->save();

            $name2 = "Billy Bartle-Barnaby";
            $enroll_date2 = "2015-07-09";
            $test_book2 = new Book($name2, $enroll_date2);
            $test_book2->save();

            //Act
            $result = Book::find($test_book2->getId());

            //Assert
            $this->assertEquals($test_book2, $result);
        }

        // test update
        function test_update()
        {
            //Arrange
            $title = "World War Z";
            $genre = "Horror";
            $test_book = new Book($title, $genre);
            $test_book->save();

            $new_name = "Reginald Irving-Jones";

            //Act
            $test_book->update($new_name);

            //Assert
            $this->assertEquals($new_name, $test_book->getTitle());

        }

        // test delete
        function test_delete()
        {
            //Arrange
            $title = "World War Z";
            $genre = "Horror";
            $test_book = new Book($title, $genre);
            $test_book->save();

            $name2 = "Billy Bartle-Barnaby";
            $genre2 = "2015-07-09";
            $test_book2 = new Book($name2, $genre2);
            $test_book2->save();

            //Act
            $test_book->delete();

            //Assert
            $result = Book::getAll();
            $this->assertEquals($test_book2, $result[0]);
        }

        function test_addAuthor()
        {
            //Arrange
            $test_book = new Book("World War Z", "Horror");
            $test_book->save();

            $test_author = new Author("High Times", "CHEM420");
            $test_author->save();

            //Act
            $test_book->addAuthor($test_author);

            //Assert
            $this->assertEquals($test_book->getAuthors(), [$test_author]);
        }

        function test_getAuthors()
        {
            //Arrange
            $test_book = new Book("World War Z", "Horror");
            $test_book->save();

            $test_book2 = new Book("Billy Bartle-Barnaby", "2015-07-09");
            $test_book2->save();

            $test_author = new Author("High Times", "CHEM420");
            $test_author->save();

            $test_author2 = new Author("Gavanese Jamelan", "MUSC69");
            $test_author2->save();

            //Act
            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author2);
            $test_book2->addAuthor($test_author2);

            //Assert
            $this->assertEquals($test_book->getAuthors(), [$test_author, $test_author2]);

        }

    }


?>
