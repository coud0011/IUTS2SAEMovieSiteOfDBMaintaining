<?php

declare(strict_types=1);

namespace Entity\Collections;

use Database\MyPdo;
use Entity\Actor;
use PDO;

class ActorsCollection
{
    /**
     * Permet de récupérer dans un array
     * tous les films de la class Movies
     * de notre base de données
     * @return Actor[]
     */
    public static function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM People
            ORDER BY name
        SQL
        );
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Actor::class);
        return $stmt->fetchAll();
    }
}
