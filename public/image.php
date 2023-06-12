<?php

declare(strict_types=1);
use Entity\Image;
use Exception\EntityNotFoundException;
use Exception\ParameterException;

try {
    if (!isset($_GET["imageId"]) || !ctype_digit($_GET["imageId"])) {
        throw new ParameterException("Pas de demande de couverture dans cover.php!");
    }
    $imageId=(int)$_GET["imageId"];
    $image=Image::findById($imageId);
    header('Content-Type: image/jpeg');
    echo $image->getJpeg();



} catch (ParameterException) {

} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
