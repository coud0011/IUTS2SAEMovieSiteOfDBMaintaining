<?php
declare(strict_types=1);

use Entity\Actor;
use Entity\Collections\CastsCollection;
use Entity\Movie;
use Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\WebPage;

try {
    if (!isset($_GET["movieId"]) || !ctype_digit($_GET["movieId"])) {
        throw new ParameterException("Parameter movieId not found or not int !");
    }
    $movieId=(int)$_GET["movieId"];
    $movie= Movie::findById($movieId);

    $webPage = new WebPage();
    $webPage->appendCssUrl("/css/style.css");
    $movieTitle=$webPage->escapeString($movie->getTitle());
    $webPage->setTitle("Films - ".$movieTitle);
    if ($movie->getPosterId()==null) {
        $poster="img/movie.png";
    } else {
        $poster="image.php?imageId={$movie->getPosterId()}";
    }
    $webPage->appendContent(
        <<<HTML
        <div class="movie">
            <img src="{$poster}" alt="Affiche du film">
            <div class="movie__info">
                <div>{$movieTitle}</div>
                <div>{$webPage->escapeString($movie->getReleaseDate())}</div>
                <div>{$webPage->escapeString($movie->getOriginalTitle())}</div>
                <div>{$webPage->escapeString($movie->getTagline())}</div>
                <div>{$webPage->escapeString($movie->getOverview())}</div>
            </div>
        </div>
    HTML
    );

    $casts = CastsCollection::findByMovieId($movieId);
    foreach ($casts as $cast) {
        $actor=Actor::findById($cast->getPeopleId());
        if ($actor->getAvatarId()==null) {
            $avatar="img/actor.png";
        } else {
            $avatar="image.php?imageId={$actor->getAvatarId()}";
        }
        $webPage->appendContent(
            <<<HTML
            <a href="actor.php?actorId={$actor->getId()}" class="actor">
                <img src="{$avatar}">
                <div class="actor__info">
                    <div>{$webPage->escapeString($cast->getRole())}</div>
                    <div>{$webPage->escapeString($actor->getName())}</div>
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