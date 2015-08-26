<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";

    $app = new Silex\Application();
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

    return $app;
?>
