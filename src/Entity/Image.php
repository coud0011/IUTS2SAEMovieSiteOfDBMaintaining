<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Exception\EntityNotFoundException;
use PDO;

class Image
{
    private int $id;
    private string $jpeg;

    public function getId(): int
    {
        return $this->id;
    }

    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    public static function findById(int $id): Image
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM Image
            WHERE id=:imageId
        SQL
        );
        $stmt->bindParam(':imageId', $id, PDO::PARAM_INT);
        $stmt->execute();
        $image=$stmt->fetchObject(Image::class);
        if (!$image) {
            throw new EntityNotFoundException("findById() - Image not found");
        }
        return $image;
    }
}
