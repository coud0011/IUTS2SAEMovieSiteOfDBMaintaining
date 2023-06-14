<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;
use Exception\EntityNotFoundException;

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

    private function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    public function getRuntime(): int
    {
        return $this->runtime;
    }

    public function getTagline(): string
    {
        return $this->tagline;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setPosterId(?int $posterId): void
    {
        $this->posterId = $posterId;
    }

    public function setOriginalLanguage(string $originalLanguage): void
    {
        $this->originalLanguage = $originalLanguage;
    }

    public function setOriginalTitle(string $originalTitle): void
    {
        $this->originalTitle = $originalTitle;
    }

    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    public function setReleaseDate(string $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    public function setRuntime(int $runtime): void
    {
        $this->runtime = $runtime;
    }

    public function setTagline(string $tagline): void
    {
        $this->tagline = $tagline;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Supprime un film par rapport à l'id courant
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
     */
    protected function update(): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            UPDATE Movie
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
        $stmt->bindValue('posterId', $this->getPosterId());
        $stmt->bindValue('originLang', $this->getOriginalLanguage());
        $stmt->bindValue('originTitle', $this->getOriginalTitle());
        $stmt->bindValue('overview', $this->getOverview());
        $stmt->bindValue('releaseDate', $this->getReleaseDate());
        $stmt->bindValue('runtime', $this->getRuntime(), PDO::PARAM_INT);
        $stmt->bindValue('tagline', $this->getTagline());
        $stmt->bindValue('title', $this->getTitle());
        $stmt->execute();
        return $this;
    }

    /**
     * Crée une nouvelle instance de Movie
     */
    public static function create(string $originLang, string $originTitle, string $overview, string $releaseDate, int $runtime, string $tagline, string $title, ?int $posterId=null, ?int $movieId=null)
    {
        $movie=new Movie();
        $movie->setId($movieId);
        $movie->setPosterId($posterId);
        $movie->setOriginalLanguage($originLang);
        $movie->setOriginalTitle($originTitle);
        $movie->setOverview($overview);
        $movie->setReleaseDate($releaseDate);
        $movie->setRuntime($runtime);
        $movie->setTagline($tagline);
        $movie->setTitle($title);
        return $movie;
    }

    /**
     * Insert le film dans la base de données
     */
    public function insert(): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            INSERT INTO Movie (posterId, originalLanguage, originalTitle, overview,  releaseDate, runtime, tagline, title)
            VALUES (:posterId, :originLang, :originTitle, :overview, :releaseDate, :runtime, :tagline, :title)
        SQL
        );
        $stmt->bindValue('posterId', $this->getPosterId(), PDO::PARAM_INT);
        $stmt->bindValue('originLang', $this->getOriginalLanguage());
        $stmt->bindValue('originTitle', $this->getOriginalTitle());
        $stmt->bindValue('overview', $this->getOverview());
        $stmt->bindValue('releaseDate', $this->getReleaseDate());
        $stmt->bindValue('runtime', $this->getRuntime(), PDO::PARAM_INT);
        $stmt->bindValue('tagline', $this->getTagline());
        $stmt->bindValue('title', $this->getTitle());
        $stmt->execute();
        $this->setId((int)MyPdo::getInstance()->lastInsertId());
        return $this;
    }

    public function save(): Movie
    {
        if ($this->getId()) {
            $this->update();
        } else {
            $this->insert();
        }
        return $this;
    }

    public static function findById(int $id): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM Movie
            WHERE id=:movieId
        SQL
        );
        $stmt->bindValue('movieId', $id, PDO::PARAM_INT);
        $stmt->execute();
        $movie=$stmt->fetchObject(Movie::class);
        if (!$movie) {
            throw new EntityNotFoundException("findById() - Movie not found");
        }
        return $movie;
    }
}
