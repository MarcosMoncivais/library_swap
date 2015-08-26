<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";

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

    //Get Calls
    $app->get("/", function() use ($app) {

        return $app['twig']->render("index.html.twig", array('books' => Book::getAll(), 'authors' => Author::getAll()));
    });

    $app->get("/book_info/{id}", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render("book_info.html.twig", array('book' => $book));
    });

    //Post Calls
    $app->post("/books", function() use ($app) {
        $title = $_POST['title'];
        $genre = $_POST['genre'];
        $book = new Book($title, $genre);
        $book->save();

        return $app['twig']->render("books.html.twig", array('books' => Book::getAll()));
    });

    $app->post("/book_info/{id}", function($id) use ($app) {
        $name = $_POST['name'];
        $author = new Author($name);
        $author->save();

        $book = Book::find($id);

        return $app['twig']->render("book_info.html.twig", array('book' => $book, 'authors' => Author::getAll()));
    });



    return $app;
?>
