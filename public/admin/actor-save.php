<?php
declare(strict_types=1);

use Exception\ParameterException;
use Html\Form\ActorForm;

try {
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