<?php
declare(strict_types=1);

use Exception\ParameterException;
use Html\Form\ActorForm;

try {
    if (!isset($_POST['birthday']) || !isset($_POST['name']) || !isset($_POST['biography']) || !isset($_POST['placeOfBirth'])) {
        throw new ParameterException('Missing parameter');
    }
    $artistForm=new ActorForm();
    $artistForm->setEntityFromQueryString();
    $artistForm->getActor()->save();
    header('Location:index.php');
    exit();
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}