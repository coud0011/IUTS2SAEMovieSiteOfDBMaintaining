<?php

declare(strict_types=1);

use Entity\Movie;
use Exception\EntityNotFoundException;
use Exception\ParameterException;

try {
    if (!isset($_GET['movieId'])) {
        throw new ParameterException('Parameter movieId not found');
    }
    $movieId=$_GET['movieId'];
    if (!ctype_digit($movieId)) {
        throw new ParameterException('Parameter movieId not int');
    }
    $movie = Movie::findById((int)$movieId);
    $movie->delete();
    header('Location:/index.php');
    exit();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
