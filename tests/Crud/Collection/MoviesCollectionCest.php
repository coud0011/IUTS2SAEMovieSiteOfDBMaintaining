<?php

namespace Tests\Crud\Collection;

use Entity\Collections\MoviesCollection;
use Entity\Movie;
use Tests\CrudTester;

class MoviesCollectionCest
{
    public function findAll(CrudTester $I): void
    {
        $expectedMovies = [
            ['id' => 503314, 'posterId' => 7628, 'originalLanguage' => 'ja', 'originalTitle' => 'ドラゴンボール超スーパー ブロリー', 'overview' => 'Quelque temps après le Tournoi du Pouvoir, la Terre est paisible. Son Goku et ses amis ont repris leur vie. Cependant, avec son expérience du Tournoi, Son Goku passe son temps à s\'entraîner pour continuer à s\'améliorer car ce dernier est conscient qu\'il reste encore beaucoup d\'individus plus forts à découvrir au sein des autres univers. Lorsqu\'un jour, le vaisseau de Freezer refait surface sur la Terre. Celui-ci est accompagné d\'un Saiyan, nommé Broly, avec son père, Paragus. La surprise de Son Goku et Vegeta est immense puisque les Saiyans sont censés avoir été complètement anéantis lors de la destruction de la planète Vegeta. Ils n\'ont donc pas d\'autre choix que de s\'affronter, mais ce nouvel ennemi s\'adapte très vite aux adversaires qu\'il affronte…', 'releaseDate'=> '2018-12-14', 'runtime' => 100, 'tagline' => 'Goku et Vegeta font face à un nouvel ennemi, le Super Saïyen Légendaire Broly !', 'title' => 'Dragon Ball Super - Broly'],
            ['id' => 630, 'posterId' => 16044, 'originalLanguage' => 'en', 'originalTitle' => 'The Wizard of Oz', 'overview' => 'Dorothy Gale, une jeune orpheline, est élevée dans une ferme du Kansas tenue par sa tante et son oncle. Son chien Toto étant persécuté par la méchante Almira Gulch, Dorothy demande aux trois ouvriers de la ferme de le protéger. Cependant personne ne semble prendre au sérieux les craintes de la jeune fille. Almira Gulch finit par s\'emparer de Toto avec l\'intention de le tuer. Mais le chien s\'échappe et retourne près de Dorothy qui décide alors de s\'enfuir. Arrivée à la ferme, une tornade se forme avant que Dorothy ne puisse se réfugier dans la cave...', 'releaseDate'=> '1939-08-15', 'runtime' => 101, 'tagline' => 'Une éblouissante fantaisie en couleurs !', 'title' => 'Le Magicien d\'Oz'],
            ['id' => 109, 'posterId' => 7373, 'originalLanguage' => 'fr', 'originalTitle' => 'Trois couleurs : Blanc', 'overview' => 'Karol a tout perdu après son divorce avec Dominique, il ne peut même pas retourner en Pologne et refuse de devenir meurtrier pour de l\'argent. Après avoir enfin réussi à retourner dans son pays, il se lance dans diverses entreprises et tombe dans le piège de sa vengeance sur Dominique.', 'releaseDate'=> '1994-01-26', 'runtime' => 100, 'tagline' => '', 'title' => 'Trois couleurs : Blanc'],
            ['id' => 108, 'posterId' => 7371, 'originalLanguage' => 'fr', 'originalTitle' => 'Trois couleurs : Bleu', 'overview' => 'Après la mort de son mari, compositeur réputé, et de leur fille dans un accident de voiture, Julie commence une nouvelle vie, coupant tout lien avec son passé. Ex-assistant du couple, Olivier, amoureux d\'elle, tente de l\'inciter à terminer le Concerto pour l\'Europe.', 'releaseDate'=> '1993-09-08', 'runtime' => 100, 'tagline' => '', 'title' => 'Trois couleurs : Bleu'],
            ['id' => 110, 'posterId' => 7369, 'originalLanguage' => 'fr', 'originalTitle' => 'Trois couleurs : Rouge', 'overview' => 'Valentine, étudiante à Genève et mannequin à ses heures, passe son temps à attendre les appels téléphoniques de son petit ami, Michel, qui vit en Angleterre. Auguste, son voisin, épris de la douce Karin, travaille d\'arrache-pied pour devenir avocat. Sans le savoir, tout ce petit monde a été placé sur écoute par un juge à la retraite, acariâtre et cynique, qui occupe ainsi sa misanthropie et ses vieux jours. Parce qu\'au volant de sa voiture, elle a renversé la chienne du juge, Valentine fait la connaissance du vieux grigou et découvre ses basses manies. Dégoûtée autant que fascinée, elle se met à lui rendre de fréquentes visites...', 'releaseDate'=> '1994-05-27', 'runtime' => 100, 'tagline' => '', 'title' => 'Trois couleurs : Rouge'],
            ['id' => 895006, 'posterId' => 1423, 'originalLanguage' => 'ja', 'originalTitle' => '鬼滅の刃 鼓屋敷編', 'overview' => '', 'releaseDate'=> '2021-09-18', 'runtime' => 87, 'tagline' => '', 'title' => '鬼滅の刃 鼓屋敷編'],
        ];
        $movies = MoviesCollection::findAll();
        $I->assertCount(count($expectedMovies), $movies);
        $I->assertContainsOnlyInstancesOf(Movie::class, $movies);
        foreach ($movies as $index => $movie) {
            $expectedMovie = $expectedMovies[$index];
            $I->assertEquals($expectedMovie['id'], $movie->getId());
            $I->assertEquals($expectedMovie['posterId'], $movie->getPosterId());
            $I->assertEquals($expectedMovie['originalLanguage'], $movie->getOriginalLanguage());
            $I->assertEquals($expectedMovie['originalTitle'], $movie->getOriginalTitle());
            $I->assertEquals($expectedMovie['overview'], $movie->getOverview());
            $I->assertEquals($expectedMovie['releaseDate'], $movie->getReleaseDate());
            $I->assertEquals($expectedMovie['runtime'], $movie->getRuntime());
            $I->assertEquals($expectedMovie['tagline'], $movie->getTagline());
            $I->assertEquals($expectedMovie['title'], $movie->getTitle());
        }
    }

    public function findByGenreId(CrudTester $I): void
    {
        $expectedMovies = [
            ['id' => 109, 'posterId' => 7373, 'originalLanguage' => 'fr', 'originalTitle' => 'Trois couleurs : Blanc', 'overview' => 'Karol a tout perdu après son divorce avec Dominique, il ne peut même pas retourner en Pologne et refuse de devenir meurtrier pour de l\'argent. Après avoir enfin réussi à retourner dans son pays, il se lance dans diverses entreprises et tombe dans le piège de sa vengeance sur Dominique.', 'releaseDate'=> '1994-01-26', 'runtime' => 100, 'tagline' => '', 'title' => 'Trois couleurs : Blanc'],
            ['id' => 108, 'posterId' => 7371, 'originalLanguage' => 'fr', 'originalTitle' => 'Trois couleurs : Bleu', 'overview' => 'Après la mort de son mari, compositeur réputé, et de leur fille dans un accident de voiture, Julie commence une nouvelle vie, coupant tout lien avec son passé. Ex-assistant du couple, Olivier, amoureux d\'elle, tente de l\'inciter à terminer le Concerto pour l\'Europe.', 'releaseDate'=> '1993-09-08', 'runtime' => 100, 'tagline' => '', 'title' => 'Trois couleurs : Bleu'],
            ['id' => 110, 'posterId' => 7369, 'originalLanguage' => 'fr', 'originalTitle' => 'Trois couleurs : Rouge', 'overview' => 'Valentine, étudiante à Genève et mannequin à ses heures, passe son temps à attendre les appels téléphoniques de son petit ami, Michel, qui vit en Angleterre. Auguste, son voisin, épris de la douce Karin, travaille d\'arrache-pied pour devenir avocat. Sans le savoir, tout ce petit monde a été placé sur écoute par un juge à la retraite, acariâtre et cynique, qui occupe ainsi sa misanthropie et ses vieux jours. Parce qu\'au volant de sa voiture, elle a renversé la chienne du juge, Valentine fait la connaissance du vieux grigou et découvre ses basses manies. Dégoûtée autant que fascinée, elle se met à lui rendre de fréquentes visites...', 'releaseDate'=> '1994-05-27', 'runtime' => 100, 'tagline' => '', 'title' => 'Trois couleurs : Rouge'],
        ];
        $movies = MoviesCollection::findByGenreId(18);
        $I->assertCount(count($expectedMovies), $movies);
        $I->assertContainsOnlyInstancesOf(Movie::class, $movies);
        foreach ($movies as $index => $movie) {
            $expectedMovie = $expectedMovies[$index];
            $I->assertEquals($expectedMovie['id'], $movie->getId());
            $I->assertEquals($expectedMovie['posterId'], $movie->getPosterId());
            $I->assertEquals($expectedMovie['originalLanguage'], $movie->getOriginalLanguage());
            $I->assertEquals($expectedMovie['originalTitle'], $movie->getOriginalTitle());
            $I->assertEquals($expectedMovie['overview'], $movie->getOverview());
            $I->assertEquals($expectedMovie['releaseDate'], $movie->getReleaseDate());
            $I->assertEquals($expectedMovie['runtime'], $movie->getRuntime());
            $I->assertEquals($expectedMovie['tagline'], $movie->getTagline());
            $I->assertEquals($expectedMovie['title'], $movie->getTitle());
        }
    }
}
