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
            $GLOBALS['DB']->exec("DELETE FROM authors_books WHERE book_id = {$this->getId()};");
        }

        function getAuthors()
        {
            $authors_query = $GLOBALS['DB']->query(
                "SELECT authors.* FROM
                    books JOIN authors_books ON (books.id = authors_books.book_id)
                             JOIN authors ON (authors_books.author_id = authors.id)
                 WHERE books.id = {$this->getId()};
                "
            );

            $matching_authors = array();
            foreach ($authors_query as $author) {
                $name = $author['name'];
                $id = $author['id'];
                $new_author = new Author($name, $id);
                array_push($matching_authors, $new_author);
            }
            return $matching_authors;
        }

        function addAuthor($new_author)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (book_id, author_id) VALUES(
                {$this->getId()},
                {$new_author->getId()}
            );");
        }

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
            //if all books are gone, all authors_books should also be deleted
            $GLOBALS['DB']->exec("DELETE FROM authors_books;");
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
