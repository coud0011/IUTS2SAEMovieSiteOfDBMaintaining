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
    $webPage->appendToHead('<link rel="icon" type="image/png" href="img/movie.png" />');
    $webPage->appendContent('<main class="movie__main">');

    $date=$webPage->escapeString($movie->getReleaseDate());
    $originTitle=$webPage->escapeString($movie->getOriginalTitle());
    $tagLine=$webPage->escapeString($movie->getTagline());
    $overview=$webPage->escapeString($movie->getOverview());
    if($date==""){
        $date="Date Inconnue";
    }
    if($originTitle==""){
        $originTitle=$movieTitle;
    }
    if($tagLine==""){
        $tagLine="Pas de slogan";
    }
    if($overview==""){
        $overview="Résumé indisponible";
    }

    $webPage->appendContent(
        <<<HTML
        
                <div class="movie__fil">
                    <div class="movie__post">
                        <img src="image.php?imageId={$movie->getPosterId()}&src=movie" alt="Film poster" class="movie__img">
                        <div class="movie__modifs">
                            <a class="movie__modify" href="admin/movie-form.php?movieId=$movieId">
                                <img class="movie__mod" src="img/modify.png" alt="modif">
                            </a>
                            <a class="movie__delete" href="admin/movie-delete.php?movieId=$movieId">
                                <img class="movie__del" src="img/delete.png" alt="modif">
                            </a>
                        </div>
                    </div>
                    <div class="movie__info">
                        <div class="movie__release">
                            <div>$movieTitle</div>
                            <div>$date</div>
                        </div>
                        <div class="movie__origin__title">$originTitle</div>
                        <div class="movie__tagline">$tagLine</div>
                        <div class="movie__overview">$overview</div>
                    </div>
                </div>
    HTML
    );
    $webPage->appendContent(<<<HTML

        
        
HTML
    );
    $webPage->appendContent('<div class="movie__actors">');
    $casts = CastsCollection::findByMovieId($movieId);
    foreach ($casts as $cast) {
        $actor=Actor::findById($cast->getPeopleId());
        if ($actor->getAvatarId()==null) {
            $avatar="img/movie.png";
        } else {
            $avatar="image.php?imageId={$actor->getAvatarId()}";
        }
        $webPage->appendContent(
            <<<HTML
                    
                        <a href="actor.php?actorId={$actor->getId()}" class="movie__actor">
                            <div class="actor__picture">
                                <img src="image.php?imageId={$actor->getAvatarId()}&src=actor" alt="Actor Avatar">
                            </div>
                            <div class="movie__actor__infos">
                                <div class="movie__actor__role">{$webPage->escapeString($cast->getRole())}</div>
                                <div class="movie__actor__name">{$webPage->escapeString($actor->getName())}</div>
                            </div>
                        </a>
        HTML
        );

    }
    $webPage->appendContent(<<<HTML
    
            </div>
        </main>
HTML
);
    echo $webPage->toHTML();
} catch (ParameterException) {
    http_response_code(400);
    echo "400";
} catch (EntityNotFoundException) {
    http_response_code(404);
    echo "404";
} catch (Exception) {
    http_response_code(500);
    echo "500";
}