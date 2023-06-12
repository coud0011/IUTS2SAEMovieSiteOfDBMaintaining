<?php

declare(strict_types=1);

namespace Entity\Collections;

use Database\MyPdo;
use Entity\Movie;
use PDO;

class MoviesCollection
{
    /**

    Méthode d'instance findAll
    Permet de récupérer dans un array
    tous les films de la class Movies
    de notre base de donnée
    @return Movie[]
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
}