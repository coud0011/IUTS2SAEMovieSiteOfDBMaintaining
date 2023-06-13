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
     * @param string $originLang
     * @param string $originTitle
     * @param string $overview
     * @param string $releaseDate
     * @param int $runtime
     * @param string $tagline
     * @param string $title
     * @param int|null $posterId
     * @param int|null $movieId
     * @return Movie
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
     * @return $this
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