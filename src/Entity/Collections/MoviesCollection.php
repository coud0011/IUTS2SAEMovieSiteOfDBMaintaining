<?php

declare(strict_types=1);

namespace Entity\Collections;

use Database\MyPdo;
use Entity\Movie;
use PDO;

class MoviesCollection
{
    /**
     * Méthode d'instance findAll
     * Permet de récupérer dans un array
     * tous les films de la class Movies
     * de notre base de donnée
     * @return Movie[]
     */
    public static function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM movie
            ORDER BY title
        SQL
        );
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Movie::class);
        return $stmt->fetchAll();
    }

    /**
     * Retourne tous les films appartenant au genre passé en paramètre
     * @param int $genreId
     * @return Movie[]
     */
    public static function findByGenreId(int $genreId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM Movie
            WHERE id IN (SELECT movieId
                         FROM movie_genre
                         WHERE genreId=:genreId)
            ORDER BY title
        SQL
        );
        $stmt->bindParam(':genreId', $genreId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Movie::class);
    }
}
