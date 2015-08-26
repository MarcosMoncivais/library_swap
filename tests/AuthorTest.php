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
    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Author::deleteAll();
            //  Book::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "High Times";
            $test_author = new Author($name);
            //Act
            $result = $test_author->getName();
            //Assert
            $this->assertEquals($name, $result);
        }

        //save test
        function test_save()
        {
            //Arrange
            $name = "Gavanese Jamelan";
            $test_author = new Author($name);
            $test_author->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals($test_author, $result[0]);
        }

        //getall test
        function test_getAll()
        {
            //Arrange
            $name = "High Times";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Gavanese Jamelan";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        //delete all test
        function test_deleteAll()
        {
            //Arrange
            $name = "High Times";
            $test_author = new Author($name);
            $test_author->save();
            $name2 = "Gavanese Jamelan";
            $test_author2 = new Author($name2);
            $test_author2->save();
            //Act
            Author::deleteAll();
            //Assert
            $result = Author::getAll();
            $this->assertEquals([], $result);
        }

        function test_update()
        {
            //Arrange
            $name = "High Times";
            $test_author = new Author($name);
            $test_author->save();
            //Act
            $new_name = "Boring Normal Chemistry";
            $test_author->update($new_name);
            //Assert
            $result = Author::getAll();
            $this->assertEquals($new_name, $result[0]->getName());
        }

        function test_find()
        {
            //Arrange
            $name = "High Times";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Gavanese Jamelan";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            $result = Author::find($test_author->getId());

            //Assert
            $this->assertEquals($test_author, $result);
        }

        function test_delete()
        {
            //Arrange
            $name = "High Times";
            $test_author = new Author($name);
            $test_author->save();
            $name2 = "Gavanese Jamelan";
            $test_author2 = new Author($name2);
            $test_author2->save();
            //Act
            $test_author->delete();
            $result = Author::getAll();
            //Assert
            $this->assertEquals($test_author2, $result[0]);
        }

        // function test_addStudent()
        // {
        //     //Arrange
        //     $test_author = new Author("Fundamentals of Human Anatomy", "SEXY101");
        //     $test_author->save();
        //     $test_author2 = new Author("Organic Chemistry of Cannabinoids", "CHEM420");
        //     $test_author2->save();
        //     $test_student = new Student("Sarah", "2000-04-01");
        //     $test_student->save();
        //     //Act
        //     $test_author->addStudent($test_student);
        //     //Assert
        //     $this->assertEquals($test_author->getStudents(), [$test_student]);
        // }
        // function test_getStudents()
        // {
        //     //Arrange
        //     $test_author = new Author("Fundamentals of Human Anatomy", "SEXY101");
        //     $test_author->save();
        //     $test_author2 = new Author("Organic Chemistry of Cannabinoids", "CHEM420");
        //     $test_author2->save();
        //     $test_student = new Student("Sarah", "2000-04-01");
        //     $test_student->save();
        //     $test_student2 = new Student("JC", "0000-12-25");
        //     $test_student2->save();
        //     //Act
        //     $test_author->addStudent($test_student);
        //     $test_author->addStudent($test_student2);
        //     $test_author2->addStudent($test_student);
        //     //Assert
        //     $this->assertEquals($test_author->getStudents(), [$test_student, $test_student2]);
        // }
    }

?>
