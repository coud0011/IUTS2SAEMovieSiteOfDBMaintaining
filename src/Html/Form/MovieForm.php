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
        return <<<HTML
            <form action="{$action}" method="post" class="form__movie">
                <input type="hidden" name="id" value="{$this?->getMovie()?->getId()}">
                <input type="hidden" name="posterId" value="{$this?->getMovie()?->getPosterId()}">
                <label for="originLang">
                    <h2>Langue originale : </h2>
                    <input type="text" name="originLang" value="{$this->escapeString($this?->getMovie()?->getOriginalLanguage())}" required>
                </label>
                <label for="originTitle">
                    <h2>Titre original :</h2>
                    <input type="text" name="originTitle" value="{$this->escapeString($this?->getMovie()?->getOriginalTitle())}" required>
                </label>
                <label for="overview">
                    <h2>Synopsis :</h2>
                    <textarea class="form__synopsis" name="overview">{$this->escapeString($this?->getMovie()?->getOverview())}</textarea>
                </label>
                <label for="releaseDate">
                    <h2>Date de sortie :</h2>
                    <input type="date" name="releaseDate" value="{$this->escapeString($this?->getMovie()?->getReleaseDate())}" required>
                </label>
                <label for="runtime">
                    <h2>Durée :</h2>
                    <input type="number" name="runtime" value="{$this?->getMovie()?->getRuntime()}" required>
                </label>
                <label for="tagline">
                    <h2>Slogan :</h2>
                    <input type="text" name="tagline" value="{$this?->getMovie()?->getTagline()}">
                </label>
                <label for="title">
                    <h2>Titre :</h2>
                    <input type="text" name="title" value="{$this?->getMovie()?->getTitle()}" required>
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
        if (empty($this->stripTagsAndTrim($_POST['originLang'])) || empty($this->stripTagsAndTrim($_POST['originTitle'])) || !isset($_POST['overview']) || empty($this->stripTagsAndTrim($_POST['releaseDate'])) || empty($_POST['runtime']) || !isset($_POST['tagline']) || empty($this->stripTagsAndTrim($_POST['title']))) {
            throw new ParameterException('setEntityFromQueryString() - Missing parameter');
        }
        $this->movie=Movie::create(
            $this->stripTagsAndTrim($_POST['originLang']),
            $this->stripTagsAndTrim($_POST['originTitle']),
            $this->stripTagsAndTrim($_POST['overview']),
            $this->stripTagsAndTrim($_POST['releaseDate']),
            (int)$_POST['runtime'],
            $this->stripTagsAndTrim($_POST['tagline']),
            $this->stripTagsAndTrim($_POST['title']),
            $posterId,
            $id
        );

    }
}
