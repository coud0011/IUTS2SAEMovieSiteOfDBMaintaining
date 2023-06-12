<?php

declare(strict_types=1);

namespace Entity\Collections;

use Database\MyPdo;
use Entity\Cast;
use PDO;

class CastsCollection
{
    /**
     * Retourne une collection de Cast correspondant au film passé en paramètre
     * @return Cast[]
     */
    public static function findByMovieId(int $movieId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM Cast
            WHERE movieId=:movieId
            ORDER BY orderIndex
        SQL
        );
        $stmt->bindParam(':movieId', $movieId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Cast::class);
    }

    /**
     * Retourne une collection de Cast correspondant à l'acteur passé en paramètre
     * @return Cast[]
     */
    public static function findByActorId(int $actorId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM Cast
            WHERE peopleId=:actorId
            ORDER BY orderIndex
        SQL
        );
        $stmt->bindParam(':actorId', $actorId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Cast::class);
    }
}
