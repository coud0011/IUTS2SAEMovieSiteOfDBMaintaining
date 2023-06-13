<?php
declare(strict_types=1);

use Exception\ParameterException;
use Html\Form\ActorForm;

try {
    if (!isset($_POST['birthday'])) {
        throw new ParameterException('Parameter birthday not found');
    }
    if (!isset($_POST['name'])) {
        throw new ParameterException('Parameter name not found');
    }
    if (!isset($_POST['biography'])) {
        throw new ParameterException('Parameter biography not found');
    }
    if (!isset($_POST['placeOfBirth'])) {
        throw new ParameterException('Parameter placeOfBirth not found');
    }
    $artistForm=new ActorForm();
    $artistForm->setEntityFromQueryString();
    $artistForm->getActor()->save();
    header('Location:/index.php');
    exit();
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}