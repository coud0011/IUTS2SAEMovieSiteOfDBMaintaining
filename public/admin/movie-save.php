<?php

declare(strict_types=1);

use Exception\ParameterException;
use Html\Form\MovieForm;

try {
    $movieForm=new MovieForm();
    $movieForm->setEntityFromQueryString();
    $movie=$movieForm->getMovie()->save();
    header("Location: /movie.php?movieId={$movie->getId()}");
    exit();
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
