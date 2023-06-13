<?php

declare(strict_types=1);

use Entity\Collections\GenresCollection;
use Entity\Collections\MoviesCollection;
use Entity\Image;
use Entity\Movie;
use Exception\EntityNotFoundException;
use Html\WebPage;


$webpage= new WebPage("Films");
if(!isset($_GET["genreId"]) || !ctype_digit($_GET["genreId"])){
    $moviesCollection=MoviesCollection::findAll();
}
else{
    $moviesCollection=MoviesCollection::findByGenreId((int)$_GET["genreId"]);
}
$webpage->appendCssUrl("css/style.css");
$webpage->appendContent('<form method="GET" action="index.php" class="genres"><h1>Filtrage par genre : </h1><select name="genreId">');
$genres=GenresCollection::findAll();
foreach($genres as $genre){
    $webpage->appendContent(<<<HTML
<option class="genre" value="{$genre->getId()}"
HTML
    );
    if(isset($_GET["genreId"]) && $_GET["genreId"]==="{$genre->getId()}"){
        $webpage->appendContent(" selected");
    }
    $webpage->appendContent(">{$genre->getName()}</option>");
}
$webpage->appendContent('<a href="index.php"><option value="" class="genre"');
if(!isset($_GET["genreId"]) || !ctype_digit($_GET["genreId"])){
    $webpage->appendContent(" selected");
}
$webpage->appendContent('>All</option></a></select><input value="Choisir ce genre" type="submit"></form>');
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
            
            <div class="movie"><a href="movie.php?movieId={$movie->getId()}">
                <div class="movie_poster">
                    <img alt="Poster du film" src="$img">
                </div>
                <div class="movie_title">{$movie->getTitle()}</div>
            </a></div>
HTML
    );
    $it+=1;
}

$webpage->appendContent('</main>');
echo $webpage->toHTML();