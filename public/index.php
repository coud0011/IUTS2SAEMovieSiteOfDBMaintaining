<?php

declare(strict_types=1);

use Entity\Collections\GenresCollection;
use Entity\Collections\MoviesCollection;
use Entity\Genre;
use Exception\EntityNotFoundException;
use Html\WebPage;


$webpage= new WebPage("Films");
try{
    if(!isset($_GET["genreId"]) || !ctype_digit($_GET["genreId"])){
        $moviesCollection=MoviesCollection::findAll();
        $genreId=null;
    }
    else{
        $genre=Genre::findById((int)$_GET["genreId"]);
        $genreId=$genre->getId();
        $moviesCollection=MoviesCollection::findByGenreId($genreId);
    }
}
catch(EntityNotFoundException){
    $moviesCollection=MoviesCollection::findAll();
    $genreId=null;
}
$webpage->appendCssUrl("css/style.css");
$webpage->appendToHead('<link rel="icon" type="image/png" href="img/cinema.png">');
$webpage->appendContent('<form method="GET" action="index.php" class="genres"><h1>Filtrage par genre : </h1><select name="genreId">');
$genres=GenresCollection::findAll();
$genreIds=[];
foreach($genres as $genre){
    $webpage->appendContent(<<<HTML
<option class="genre" value="{$genre->getId()}"
HTML
    );
    if($genreId===$genre->getId()){
        $webpage->appendContent(" selected");
    }
    $webpage->appendContent(">{$genre->getName()}</option>");
}
$webpage->appendContent('<a href="index.php"><option value="" class="genre"');
if($genreId===null){
    $webpage->appendContent(" selected");
}
$webpage->appendContent('>All</option></a></select><input value="Choisir ce genre" type="submit"><a href="admin/movie-form.php"><img src="img/Add.png" alt="Add Movie"></a></form>');
$webpage->appendContent('<main class="index__main">');


foreach($moviesCollection as $movie){
    $webpage->appendContent(<<<HTML
            
            <div class="movie"><a href="movie.php?movieId={$movie->getId()}">
                <div class="movie__poster">
                    <img alt="Film Poster" src="image.php?imageId={$movie->getPosterId()}&src=movie">
                </div>
                <div class="movie__title">{$movie->getTitle()}</div>
            </a></div>
HTML
    );
}

$webpage->appendContent('</main>');
echo $webpage->toHTML();