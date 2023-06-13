<?php
declare(strict_types=1);

use Entity\Actor;
use Entity\Collections\CastsCollection;
use Entity\Movie;
use Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\WebPage;

try {
    if (!isset($_GET["actorId"]) || !ctype_digit($_GET["actorId"])) {
        throw new ParameterException("Parameter actorId not found or not int !");
    }
    $actorId=(int)$_GET["actorId"];
    $actor= Actor::findById($actorId);

    $webPage = new WebPage();
    $webPage->appendCssUrl("/css/style.css");
    $actorName=$webPage->escapeString($actor->getName());
    $webPage->setTitle("Films - ".$actorName);
    $webPage->appendToHead('<link rel="icon" type="image/png" href="/img/cinema.png" />');
    if ($actor->getAvatarId()==null) {
        $avatar="img/actor.png";
    } else {
        $avatar="image.php?imageId={$actor->getAvatarId()}";
    }
    $webPage->appendContent(
        <<<HTML
        <div class="actor">
            <img src="{$avatar}" alt="Actor avatar">
            <div class="actor__info">
                <div>{$actorName}</div>
                <div>{$webPage->escapeString($actor->getPlaceOfBirth())}</div>
                <div>{$webPage->escapeString($actor->getBirthday())} - {$webPage->escapeString($actor->getDeathday())}</div>
                <div>{$webPage->escapeString($actor->getBiography())}</div>
            </div>
        </div>
    HTML
    );

    $casts = CastsCollection::findByActorId($actorId);
    foreach ($casts as $cast) {
        $movie= Movie::findById($cast->getMovieId());
        if ($movie->getPosterId()==null) {
            $poster="img/actor.png";
        } else {
            $poster="image.php?imageId={$movie->getPosterId()}";
        }
        $webPage->appendContent(
            <<<HTML
            <a href="movie.php?movieId={$movie->getId()}" class="movie">
                <img src="{$poster}">
                <div class="movie__info">
                    <div>
                        <div>{$webPage->escapeString($movie->getTitle())}</div>
                        <div>{$movie->getReleaseDate()}</div>
                    </div>
                    <div>{$webPage->escapeString($cast->getRole())}</div>
                </div>
            </a>
        HTML
        );
    }

    echo $webPage->toHTML();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}