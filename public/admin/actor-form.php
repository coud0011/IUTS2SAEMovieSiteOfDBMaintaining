<?php
declare(strict_types=1);

use Entity\Actor;
use Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\Form\ActorForm;
use Html\WebPage;

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

    $webpage=new WebPage();
    $webpage->setTitle('Admin - Ajouter ou modifier un acteur');
    $webpage->appendContent($actorForm->getHtmlForm("actor-save.php"));
    echo $webpage->toHTML();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}