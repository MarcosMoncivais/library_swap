<?php

    class Book
    {
        private $title;
        private $genre;
        private $id;

        function __construct($title, $genre, $id = null)
        {
            $this->title = $title;
            $this->genre = $genre;
            $this->id = $id;
        }

        // Getters and Setters
        function getTitle()
        {
            return $this->title;
        }

        function setTitle($new_title)
        {
            $this->title = $new_title;
        }

        function getGenre()
        {
            return $this->genre;
        }

        function setGenre($new_genre)
        {
            $this->genre = $new_genre;
        }

        function getId()
        {
            return $this->id;
        }

        // Database methods
        function save()
        {
            $GLOBALS['DB']->exec(
                "INSERT INTO books (title, genre) VALUES(
                    '{$this->getTitle()}',
                    '{$this->getGenre()}'
                );"
            );
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_title)
        {
            $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()};");
            $this->setTitle($new_title);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
            //$GLOBALS['DB']->exec("DELETE FROM enrollments WHERE book_id = {$this->getId()};");
        }

        // function getCourses()
        // {
        //     $courses_query = $GLOBALS['DB']->query(
        //         "SELECT courses.* FROM
        //             books JOIN enrollments ON (enrollments.book_id = books.id)
        //                      JOIN courses     ON (enrollments.course_id = courses.id)
        //          WHERE books.id = {$this->getId()};
        //         "
        //     );
        //     $matching_courses = array();
        //     foreach ($courses_query as $course) {
        //         $title = $course['title'];
        //         $code = $course['code'];
        //         $id = $course['id'];
        //         $new_course = new Course($title, $code, $id);
        //         array_push($matching_courses, $new_course);
        //     }
        //     return $matching_courses;
        // }

        // function addCourse($new_course)
        // {
        //     $GLOBALS['DB']->exec("INSERT INTO enrollments (book_id, course_id) VALUES(
        //         {$this->getId()},
        //         {$new_course->getId()}
        //     );");
        // }

        static function getAll()
        {
            $books_query = $GLOBALS['DB']->query("SELECT * FROM books;");
            $all_books = array();
            foreach ($books_query as $book) {
                $title = $book['title'];
                $genre = $book['genre'];
                $id = $book['id'];
                $new_book = new Book($title, $genre, $id);
                array_push($all_books, $new_book);
            }
            return $all_books;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books;");
            //if all books are gone, all enrollments should also be deleted
            //$GLOBALS['DB']->exec("DELETE FROM enrollments;");
        }

        static function find($search_id)
        {
            $found_book = null;
            $all_books = Book::getAll();
            foreach ($all_books as $book) {
                if ($book->getId() == $search_id) {
                    $found_book = $book;
                }
            }
            return $found_book;
        }

    }

?>
