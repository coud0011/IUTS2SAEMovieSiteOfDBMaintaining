<?php

declare(strict_types=1);
use Entity\Image;
use Exception\EntityNotFoundException;
use Exception\ParameterException;

try {
    if (!isset($_GET["imageId"]) || !ctype_digit($_GET["imageId"])) {
        throw new ParameterException("No image in image.php!");
    }
    $imageId=(int)$_GET["imageId"];
    $image=Image::findById($imageId);
    header('Content-Type: image/jpeg');
    echo $image->getJpeg();



} catch (ParameterException|EntityNotFoundException|Exception) {
    if(!isset($_GET["src"])) {
        http_response_code(404);
    }
    switch($_GET["src"]) {
        case 'movie':
            header("Location: img/movie.png");
            exit();
        case 'actor':
            header("Location: img/actor.png");
            exit();
        default:
            http_response_code(500);
    }
}
