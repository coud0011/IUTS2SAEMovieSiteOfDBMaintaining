<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Exception\EntityNotFoundException;
use PDO;

class Cast
{
    private int $id;
    private int $movieId;
    private int $peopleId;
    private string $role;
    private int $orderIndex;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }

    /**
     * @return int
     */
    public function getPeopleId(): int
    {
        return $this->peopleId;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return int
     */
    public function getOrderIndex(): int
    {
        return $this->orderIndex;
    }

    /**
     * Retourne le Cast correspondant au film passé en paramètre
     * @return Cast
     */
    public static function findByMovieId(int $movieId): Cast
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
        $cast=$stmt->fetchObject(Cast::class);
        if (!$cast) {
            throw new EntityNotFoundException("findByMovieId() - Cast not found");
        }
        return $cast;
    }

    public static function findByActorId(int $actorId): Cast
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
        $cast=$stmt->fetchObject(Cast::class);
        if (!$cast) {
            throw new EntityNotFoundException("findByActorId() - Cast not found");
        }
        return $cast;
    }
}