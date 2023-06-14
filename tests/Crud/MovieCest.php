<?php

namespace Tests\Crud;

use Entity\Movie;
use Exception\EntityNotFoundException;
use Tests\CrudTester;

class MovieCest
{
    public function findById(CrudTester $I): void
    {
        $movie = Movie::findById(108);
        $I->assertSame(108, $movie->getId());
        $I->assertSame(7371, $movie->getPosterId());
        $I->assertSame('fr', $movie->getOriginalLanguage());
        $I->assertSame('Trois couleurs : Bleu', $movie->getOriginalTitle());
        $I->assertSame('Après la mort de son mari, compositeur réputé, et de leur fille dans un accident de voiture, Julie commence une nouvelle vie, coupant tout lien avec son passé. Ex-assistant du couple, Olivier, amoureux d\'elle, tente de l\'inciter à terminer le Concerto pour l\'Europe.', $movie->getOverview());
        $I->assertSame('1993-09-08', $movie->getReleaseDate());
        $I->assertSame(100, $movie->getRuntime());
        $I->assertSame('', $movie->getTagline());
        $I->assertSame('Trois couleurs : Bleu', $movie->getTitle());
    }

    public function findByIdThrowsExceptionIfMovieDoesNotExist(CrudTester $I): void
    {
        $I->expectThrowable(EntityNotFoundException::class, function () {
            Movie::findById(PHP_INT_MAX);
        });
    }

    public function delete(CrudTester $I): void
    {
        $movie = Movie::findById(108);
        $movie->delete();
        $I->cantSeeInDatabase('movie', ['id' => 108]);
        $I->cantSeeInDatabase('movie', ['originalTitle' => 'Trois couleurs : Bleu']);
        $I->cantSeeInDatabase('movie', ['overview' => 'Après la mort de son mari, compositeur réputé, et de leur fille dans un accident de voiture, Julie commence une nouvelle vie, coupant tout lien avec son passé. Ex-assistant du couple, Olivier, amoureux d\'elle, tente de l\'inciter à terminer le Concerto pour l\'Europe.']);
        $I->cantSeeInDatabase('movie', ['title' => 'Trois couleurs : Bleu']);
        $I->assertNull($movie->getId());
        $I->assertSame('Trois couleurs : Bleu', $movie->getOriginalTitle());
    }

    public function update(CrudTester $I): void
    {
        $movie = Movie::findById(108);
        $movie->setOriginalLanguage('en');
        $movie->setOriginalTitle('Deux couleurs : Bleu');
        $movie->setOverview('Test');
        $movie->setReleaseDate('2022-05-12');
        $movie->setRuntime(50);
        $movie->setTagline('azerty');
        $movie->setTitle('Deux couleurs : Bleu');
        $movie->save();
        $I->canSeeNumRecords(1, 'movie', [
            'id' => 108,
            'originalLanguage' => 'en',
            'originalTitle' => 'Deux couleurs : Bleu',
            'releaseDate' => '2022-05-12',
            'runtime' => 50,
            'tagline' => 'azerty',
            'overview' => 'Test',
            'title' => 'Deux couleurs : Bleu',
        ]);
        $I->assertSame(108, $movie->getId());
        $I->assertSame('en', $movie->getOriginalLanguage());
        $I->assertSame('Deux couleurs : Bleu', $movie->getOriginalTitle());
        $I->assertSame('Test', $movie->getOverview());
        $I->assertSame('2022-05-12', $movie->getReleaseDate());
        $I->assertSame(50, $movie->getRuntime());
        $I->assertSame('azerty', $movie->getTagline());
        $I->assertSame('Deux couleurs : Bleu', $movie->getTitle());
    }

    public function createWithoutId(CrudTester $I)
    {
        $movie = Movie::create('fr', 'titre1', 'Pas de résumé', '2023-06-14', '50', '', 'titre1');
        $I->assertNull($movie->getId());
        $I->assertNull($movie->getPosterId());
        $I->assertSame('fr', $movie->getOriginalLanguage());
        $I->assertSame('titre1', $movie->getOriginalTitle());
        $I->assertSame('Pas de résumé', $movie->getOverview());
        $I->assertSame('2023-06-14', $movie->getReleaseDate());
        $I->assertSame(50, $movie->getRuntime());
        $I->assertSame('', $movie->getTagline());
        $I->assertSame('titre1', $movie->getTitle());
    }

    public function createWithId(CrudTester $I)
    {
        $movie = Movie::create('fr', 'titre1', 'Pas de résumé', '2023-06-14', '50', '', 'titre1', 7371, 108);
        $I->assertSame(108, $movie->getId());
        $I->assertSame(7371, $movie->getPosterId());
        $I->assertSame('fr', $movie->getOriginalLanguage());
        $I->assertSame('titre1', $movie->getOriginalTitle());
        $I->assertSame('Pas de résumé', $movie->getOverview());
        $I->assertSame('2023-06-14', $movie->getReleaseDate());
        $I->assertSame(50, $movie->getRuntime());
        $I->assertSame('', $movie->getTagline());
        $I->assertSame('titre1', $movie->getTitle());
    }

    public function insert(CrudTester $I)
    {
        $movie = Movie::create('fr', 'titre1', 'Pas de résumé', '2023-06-14', '50', '', 'titre1');
        $movie->save();
        $I->canSeeNumRecords(1, 'movie', [
            'id' => 895007,
            'posterId' => null,
            'originalLanguage' => 'fr',
            'originalTitle' => 'titre1',
            'overview' => 'Pas de résumé',
            'releaseDate' => '2023-06-14',
            'runtime' => 50,
            'tagline' => '',
            'title' => 'titre1',
        ]);
        $I->assertSame($movie->getId(), 895007);
        $I->assertSame($movie->getPosterId(), null);
        $I->assertSame($movie->getOriginalLanguage(), 'fr');
        $I->assertSame($movie->getOriginalTitle(), 'titre1');
        $I->assertSame($movie->getOverview(), 'Pas de résumé');
        $I->assertSame($movie->getReleaseDate(), '2023-06-14');
        $I->assertSame($movie->getRuntime(), 50);
        $I->assertSame($movie->getTagline(), '');
        $I->assertSame($movie->getTitle(), 'titre1');
    }
}
