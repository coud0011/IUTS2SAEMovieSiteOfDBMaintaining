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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public static function findById(int $id): Genre
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM Image
            WHERE id=:genreId
        SQL
        );
        $stmt->bindParam(':genreId', $id, PDO::PARAM_INT);
        $stmt->execute();
        $genre=$stmt->fetchObject(Image::class);
        if (!$genre) {
            throw new EntityNotFoundException("findById() - Genre not found");
        }
        return $genre;
    }
}