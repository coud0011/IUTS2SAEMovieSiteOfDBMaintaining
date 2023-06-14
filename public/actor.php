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
    $movieId=(int)$_GET["actorId"];
    $actor= Actor::findById($movieId);

    $webPage = new WebPage();
    $webPage->appendCssUrl("/css/style.css");
    $actorName=$webPage->escapeString($actor->getName());
    $webPage->setTitle("Films - ".$actorName);
    $webPage->appendToHead('<link rel="icon" type="image/png" href="img/actor.png" />');
    $webPage->appendContent('<main class="actor__main">');
    $pob=$webPage->escapeString($actor->getPlaceOfBirth());
    $bio=$webPage->escapeString($actor->getBiography());
    if($pob=="") {
        $pob="Lieu de naissance inconnu";
    }
    if($bio=="") {
        $bio="Pas de biographie";
    }

    if($actor->getDeathday()===null) {
        $deathDay="vivant";
    } else {
        $deathDay=$webPage->escapeString($actor->getDeathday())===null;
    }
    $dates="{$webPage->escapeString($actor->getBirthday())} - {$deathDay}";
    $webPage->appendContent(
        <<<HTML
        <div class="actor__pers">
            <div class="actor__perso">
                <img src="image.php?imageId={$actor->getAvatarId()}&src=actor" alt="Actor avatar" class="actor__avatar">
            </div>
            <div class="actor__info">
                <div class="actor__name">{$actorName}</div>
                <div class="actor__pob">$pob</div>
                <div class="actor__birthday">$dates</div>
                <div class="actor__bio"><p>$bio</p></div>
            </div>
        </div>
    HTML
    );
    $webPage->appendContent('<div class="actor__movies">');
    $casts = CastsCollection::findByActorId($movieId);
    foreach ($casts as $cast) {
        $movie= Movie::findById($cast->getMovieId());
        $webPage->appendContent(
            <<<HTML
            <a href="movie.php?movieId={$movie->getId()}" class="actor__movie">
                <div class="movie__poster">
                    <img src="image.php?imageId={$movie->getPosterId()}&src=actor" alt="Film poster">
                </div>
                <div class="actor__movie__infos">
                    <div class="movie__infos__imp">
                        <div class="actor__movie__title">{$webPage->escapeString($movie->getTitle())}</div>
                        <div class="actor__movie__date">{$movie->getReleaseDate()}</div>
                    </div>
                    <div class="actor__movie__role">{$webPage->escapeString($cast->getRole())}</div>
                </div>
            </a>
        HTML
        );
    }
    $webPage->appendContent('</main>');
    echo $webPage->toHTML();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
