<?php
declare(strict_types=1);

use Entity\Movie;
use Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\Form\MovieForm;
use Html\WebPage;

try {
    $movie=null;
    if (isset($_GET['movieId'])) {
        $movieId=$_GET['movieId'];
        if (!ctype_digit($movieId)) {
            throw new ParameterException('Parameter movieId not int');
        }
        $movie = Movie::findById((int)$movieId);
    }
    $movieForm=new MovieForm($movie);

    $webpage=new WebPage();
    $webpage->setTitle('Admin - Ajouter ou modifier un film');
    $webpage->appendCssUrl("/css/style.css");
    $webpage->appendContent($movieForm->getHtmlForm("movie-save.php"));
    echo $webpage->toHTML();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}