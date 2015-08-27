<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Patron.php";

    $app = new Silex\Application();
    // $app [debug] = true;

    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__."/../views"
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //Main page
    $app->get("/", function() use ($app) {

        return $app['twig']->render("index.html.twig");
    });

    //Librarian Portal
    $app->get("/librarian", function() use ($app) {
        return $app['twig']->render("librarian.html.twig");
    });

    $app->get("/search_books", function() use($app) {
        return $app['twig']->render("librarian_books.html.twig", array('books' => Book::getAll()));
    });
    $app->get("/book_info/{id}", function($id) use($app) {
        $book = Book::find($id);
        return $app['twig']->render('librarian_book.html.twig', array('book' => $book, 'authors' => $book->getAuthors(), 'all_authors' => Author::getAll()));
    });



    return $app;
?>
