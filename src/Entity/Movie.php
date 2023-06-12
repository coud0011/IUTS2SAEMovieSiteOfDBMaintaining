<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class Movie
{
    private ?int $id;
    private ?int $posterId;
    private string $originalLanguage;
    private string $originalTitle;
    private string $overview;
    private string $releaseDate;
    private int $runtime;
    private string $tagline;
    private string $title;

    public function __construct()
    {

    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /**
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /**
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @return int
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }

    /**
     * @return string
     */
    public function getTagline(): string
    {
        return $this->tagline;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param int|null $posterId
     */
    public function setPosterId(?int $posterId): void
    {
        $this->posterId = $posterId;
    }

    /**
     * @param string $originalLanguage
     */
    public function setOriginalLanguage(string $originalLanguage): void
    {
        $this->originalLanguage = $originalLanguage;
    }

    /**
     * @param string $originalTitle
     */
    public function setOriginalTitle(string $originalTitle): void
    {
        $this->originalTitle = $originalTitle;
    }

    /**
     * @param string $overview
     */
    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    /**
     * @param string $releaseDate
     */
    public function setReleaseDate(string $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @param int $runtime
     */
    public function setRuntime(int $runtime): void
    {
        $this->runtime = $runtime;
    }

    /**
     * @param string $tagline
     */
    public function setTagline(string $tagline): void
    {
        $this->tagline = $tagline;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Supprime un film par rapport à l'id courant
     * @return $this
     */
    public function delete(): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            DELETE FROM Movie
            WHERE id=:movieId
        SQL
        );
        $stmt->bindValue('movieId', $this->getId(), PDO::PARAM_INT);
        $stmt->execute();
        $this->id=null;
        return $this;
    }

    /**
     * Met à jour le film
     * @return $this
     */
    protected function update(): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            UPDATE Artist
            SET posterId=:posterId,
                originalLanguage=:originLang,
                originalTitle=:originTitle,
                overview=:overview,
                releaseDate=:releaseDate,
                runtime=:runtime,
                tagline=:tagline,
                title=:title
            WHERE id=:movieId
        SQL
        );
        $stmt->bindValue('movieId', $this->getId(), PDO::PARAM_INT);
        $stmt->bindValue('posterId', $this->getPosterId(), PDO::PARAM_INT);
        $stmt->bindValue('originLang', $this->getOriginalLanguage());
        $stmt->bindValue('originTitle', $this->getOriginalTitle());
        $stmt->bindValue('releaseDate', $this->getReleaseDate());
        $stmt->bindValue('runtime', $this->getRuntime(), PDO::PARAM_INT);
        $stmt->bindValue('tagline', $this->getTagline());
        $stmt->bindValue('title', $this->getTitle());
        $stmt->execute();
        return $this;
    }
}