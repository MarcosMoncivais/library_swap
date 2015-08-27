<?php

    class Author
{
    private $name;
    private $id;

    function __construct($name, $id = null)
    {
        $this->name = $name;
        $this->id = $id;
    }

    // Getters and Setters
    function getName()
    {
        return $this->name;
    }

    function setName($new_name)
    {
        $this->name = $new_name;
    }

    function getId()
    {
        return $this->id;
    }

    // Database storage methods
    function save()
    {
        $GLOBALS['DB']->exec(
            "INSERT INTO authors (name) VALUES (
                '{$this->getName()}'
            );"
        );
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function update($new_name)
    {
        $GLOBALS['DB']->exec("UPDATE authors SET name = '{$new_name}' WHERE id = {$this->getId()};");
        $this->setName($new_name);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
        $GLOBALS['DB']->exec("DELETE FROM authors_books WHERE author_id = {$this->getId()};");
    }

    //These methods involve the other class
    function addBook($new_book)
    {
        $GLOBALS['DB']->exec("INSERT INTO authors_books (book_id, author_id) VALUES (
            {$new_book->getId()},
            {$this->getId()}
        );");
    }

    function getBooks()
    {
        $books_query = $GLOBALS['DB']->query(
            "SELECT books.* FROM
                authors JOIN authors_books ON (authors.id = authors_books.author_id)
                        JOIN books ON (authors_books.book_id = books.id)
             WHERE authors.id = {$this->getId()};
            "
        );

        $matching_books = array();
        foreach ($books_query as $book) {
            $title = $book['title'];
            $genre = $book['genre'];
            $id = $book['id'];
            $new_book = new Book($title, $genre, $id);
            array_push($matching_books, $new_book);
        }
        return $matching_books;
    }

    static function getAll()
    {
        $authors_query = $GLOBALS['DB']->query("SELECT * FROM authors;");
        $all_authors = array();
        foreach ($authors_query as $author) {
            $name = $author['name'];
            $id = $author['id'];
            $new_author = new Author($name, $id);
            array_push($all_authors, $new_author);
        }
        return $all_authors;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM authors;");
    }

    static function find($search_id)
    {
        $found_author = null;
        $author = Author::getAll();
        foreach ($author as $author) {
            $author_id = $author->getId();
            if ($author_id == $search_id) {
                $found_author = $author;
            }
        }
        return $found_author;
    }
}

?>
