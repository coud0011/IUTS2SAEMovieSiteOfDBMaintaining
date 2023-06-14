<?php

declare(strict_types=1);

use Entity\Actor;
use Exception\EntityNotFoundException;
use Exception\ParameterException;

try {
    if (!isset($_GET['actorId'])) {
        throw new ParameterException('Parameter actorId not found');
    }
    $actorId=$_GET['actorId'];
    if (!ctype_digit($actorId)) {
        throw new ParameterException('Parameter actorId not int');
    }
    $actor = Actor::findById((int)$actorId);
    $actor->delete();
    header('Location:/index.php');
    exit();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
