<?php
namespace Tests;
use Codeception\Stub;
use Entity\Movie;
use Html\Form\MovieForm;
use Tests\FormTester;
class MovieFormCest
{
    public function correctBaseStructure(FormTester $I)
    {
        $movie = Stub::make(Movie::class, [
            'id' => 895007,
            'posterId' => null,
            'originalLanguage' => 'fr',
            'originalTitle' => 'titre1',
            'overview' => 'Pas de résumé',
            'releaseDate' => '2023-06-14',
            'runtime' => 50,
            'tagline' => '',
            'title' => 'titre1'
        ]);
        $I->amTestingPartialHtmlContent((new MovieForm($movie))->getHtmlForm('go.php'));

        $I->seeElement('form[method="post"][action="go.php"]');
        $I->seeElement('form input[type="hidden"][name="id"]');
        $I->seeElement('form input[type="hidden"][name="posterId"  ]');
        $I->seeElement('form input[type="text"][name="originLang"][required]');
        $I->seeElement('form input[type="text"][name="originTitle"][required]');
        $I->seeElement('form textarea[name="overview"]');
        $I->seeElement('form input[type="date"][name="releaseDate"][required]');
        $I->seeElement('form input[type="number"][name="runtime"][required]');
        $I->seeElement('form input[type="text"][name="tagline"]');
        $I->seeElement('form input[type="text"][name="title"][required]');
        $I->seeElement('form *[type="submit"]');
    }

    public function checkValuesOfNewMovie(FormTester $I)
    {
        $I->amTestingPartialHtmlContent((new MovieForm())->getHtmlForm('go.php'));

        $I->seeElement('form[method="post"][action="go.php"]');
        $I->seeElement('form input[type="hidden"][name="id"][value=""]');
        $I->seeElement('form input[type="hidden"][name="posterId"  ][value=""]');
        $I->seeElement('form input[type="text"][name="originLang"][value=""][required]');
        $I->seeElement('form input[type="text"][name="originTitle"][value=""][required]');
        $I->seeElement('form textarea[name="overview"]');
        $I->seeElement('form input[type="date"][name="releaseDate"][value=""][required]');
        $I->seeElement('form input[type="number"][name="runtime"][value=""][required]');
        $I->seeElement('form input[type="text"][name="tagline"][value=""]');
        $I->seeElement('form input[type="text"][name="title"][value=""][required]');
    }

    public function checkValuesOfExistingArtist(FormTester $I)
    {
        $movie = Stub::make(Movie::class, [
            'id' => 895007,
            'posterId' => null,
            'originalLanguage' => 'fr',
            'originalTitle' => 'titre1',
            'overview' => 'Pas de résumé',
            'releaseDate' => '2023-06-14',
            'runtime' => 50,
            'tagline' => '',
            'title' => 'titre1'
        ]);
        $I->amTestingPartialHtmlContent((new MovieForm($movie))->getHtmlForm('go.php'));

        $I->seeElement('form input[type="hidden"][name="id"][value="895007"]');
        $I->seeElement('form input[type="hidden"][name="posterId"][value=""]');
        $I->seeElement('form input[type="text"][name="originLang"][value="fr"][required]');
        $I->seeElement('form input[type="text"][name="originTitle"][value="titre1"][required]');
        $I->seeElement('form textarea[name="overview"]');
        $I->seeElement('form input[type="date"][name="releaseDate"][value="2023-06-14"][required]');
        $I->seeElement('form input[type="number"][name="runtime"][value="50"][required]');
        $I->seeElement('form input[type="text"][name="tagline"][value=""]');
        $I->seeElement('form input[type="text"][name="title"][value="titre1"][required]');
    }
}
