<?php

declare(strict_types=1);

namespace Entity\Collections;

use Database\MyPdo;
use Entity\Genre;
use PDO;

class GenresCollection
{
    /**
     * Retourne tous les genres
     * @return Genre[]
     */
    public static function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM Genre
            ORDER BY name
        SQL
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Genre::class);
    }
}
