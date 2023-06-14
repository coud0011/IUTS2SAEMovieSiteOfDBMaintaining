<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Exception\EntityNotFoundException;
use PDO;

class Genre
{
    private int $id;
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function findById(int $id): Genre
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM Genre
            WHERE id=:genreId
        SQL
        );
        $stmt->bindParam(':genreId', $id, PDO::PARAM_INT);
        $stmt->execute();
        $genre=$stmt->fetchObject(Genre::class);
        if (!$genre) {
            throw new EntityNotFoundException("findById() - Genre not found");
        }
        return $genre;
    }
}
