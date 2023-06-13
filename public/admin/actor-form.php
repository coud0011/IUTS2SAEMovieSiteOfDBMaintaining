<?php
declare(strict_types=1);

use Entity\Actor;
use Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\Form\ActorForm;

try {
    $actor=null;
    if (isset($_GET['actorId'])) {
        $actorId=$_GET['actorId'];
        if (!ctype_digit($actorId)) {
            throw new ParameterException('Parameter actorId not int');
        }
        $actor = Actor::findById((int)$actorId);
    }
    $actorForm=new ActorForm($actor);
    echo $actorForm->getHtmlForm("actor-save.php");
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}