<?php

declare(strict_types=1);

use Entity\Collections\MoviesCollection;
use Entity\Image;
use Entity\Movie;
use Exception\EntityNotFoundException;
use Html\WebPage;


$webpage= new WebPage("Films");
$moviesCollection=MoviesCollection::findAll();
$webpage->appendCssUrl("css/style.css");
$webpage->appendContent('<main>');

$it=0;
foreach($moviesCollection as $movie){
    $img=$movie->getPosterId();
    if($img===null){
        $img="img/movie.png";
    }
    else{
        $img="image.php?imageId={$img}";
    }
    $webpage->appendContent(<<<HTML
            
            <div class="movie">
                <div class="movie_poster">
                    <img alt="Poster du film" src="$img">
                </div>
                <div class="movie_title">{$movie->getTitle()}</div>
            </div>
HTML
    );
    $it+=1;
}

$webpage->appendContent('</main>');
echo $webpage->toHTML();