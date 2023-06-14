<?php
declare(strict_types=1);

namespace Html\Form;

use Entity\Movie;
use Exception\ParameterException;
use Html\StringEscaper;

class MovieForm
{
    use StringEscaper;
    private ?Movie $movie;

    /**
     * @param Movie|null $movie
     */
    public function __construct(?Movie $movie=null)
    {
        $this->movie = $movie;
    }

    /**
     * @return Movie|null
     */
    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    /**
     * @param string $action
     * @return string
     */
    public function getHtmlForm(string $action): string
    {
        $id=$this?->getMovie()?->getId();
        $posterId=$this?->getMovie()?->getPosterId();
        $originLang=$this?->getMovie()?->getOriginalLanguage();
        $originTitle=$this?->getMovie()?->getOriginalTitle();
        $overview=$this?->getMovie()?->getOverview();
        $releaseDate=$this?->getMovie()?->getReleaseDate();
        $runtime=$this?->getMovie()?->getRuntime();
        $tagline=$this?->getMovie()?->getTagline();
        $title=$this?->getMovie()?->getTitle();
        return <<<HTML
            <form action="{$action}" method="post" class="form__movie">
                <input type="hidden" name="id" value="{$id}">
                <input type="hidden" name="posterId" value="{$posterId}">
                <label for="originLang">
                    <h2>Langue originale : </h2>
                    <input type="text" name="originLang" value="{$this->escapeString($originLang)}">
                </label>
                <label for="originTitle">
                    <h2>Titre original :</h2>
                    <input type="text" name="originTitle" value="{$this->escapeString($originTitle)}">
                </label>
                <label for="overview">
                    <h2>Synopsis :</h2>
                    <textarea class="form__synopsis" name="overview">{$this->escapeString($overview)}</textarea>
                </label>
                <label for="releaseDate">
                    <h2>Date de sortie :</h2>
                    <input type="date" name="releaseDate" value="{$this->escapeString($releaseDate)}">
                </label>
                <label for="runtime">
                    <h2>Durée :</h2>
                    <input type="number" name="runtime" value="$runtime">
                </label>
                <label for="tagline">
                    <h2>Slogan :</h2>
                    <input type="text" name="tagline" value="{$this->escapeString($tagline)}">
                </label>
                <label for="title">
                    <h2>Titre :</h2>
                    <input type="text" name="title" value="{$this->escapeString($title)}">
                </label>
                <input type="submit" value="Enregistrer">
            </form>
        HTML;
    }

    /**
     * @return void
     * @throws ParameterException
     */
    public function setEntityFromQueryString(): void
    {
        $id=null;
        if (isset($_POST['id']) && ctype_digit($_POST['id'])) {
            $id=(int)$_POST['id'];
        }
        $posterId=null;
        if (isset($_POST['posterId']) && ctype_digit($_POST['posterId'])) {
            $posterId=(int)$_POST['posterId'];
        }
        $tagline="";
        if (isset($_POST['tagline'])) {
            $tagline=$this->stripTagsAndTrim($_POST['tagline']);
        }
        if (!isset($_POST['originLang']) || !isset($_POST['originTitle']) || !isset($_POST['overview']) || !isset($_POST['releaseDate']) || !isset($_POST['runtime']) || !isset($_POST['title'])) {
            throw new ParameterException('setEntityFromQueryString() - Missing parameter');
        }
        $originLang = $this->stripTagsAndTrim($_POST['originLang']);
        $originTitle = $this->stripTagsAndTrim($_POST['originTitle']);
        $overview = $this->stripTagsAndTrim($_POST['overview']);
        $releaseDate = $this->stripTagsAndTrim($_POST['releaseDate']);
        $runtime = (int)$_POST['runtime'];
        $title = $this->stripTagsAndTrim($_POST['title']);
        $this->movie=Movie::create($originLang, $originTitle, $overview, $releaseDate, $runtime, $tagline, $title, $posterId, $id);
    }
}