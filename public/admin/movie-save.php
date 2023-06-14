<?php
declare(strict_types=1);

use Exception\ParameterException;
use Html\Form\MovieForm;

try {
    $movieForm=new MovieForm();
    $movieForm->setEntityFromQueryString();
    $movieForm->getMovie()->save();
    header('Location:/index.php');
    exit();
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}