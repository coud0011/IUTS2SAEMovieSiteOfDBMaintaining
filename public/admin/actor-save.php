<?php

declare(strict_types=1);

use Exception\ParameterException;
use Html\Form\ActorForm;

try {
    $artistForm=new ActorForm();
    $artistForm->setEntityFromQueryString();
    $artistForm->getActor()->save();
    http_response_code(302);
    header("Location: /actor.php?actorId={$artistForm->getActor()->getId()}");
    exit();
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
