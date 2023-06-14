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

    public function getId(): int
    {
        return $this->id;
    }

    public function getMovieId(): int
    {
        return $this->movieId;
    }

    public function getPeopleId(): int
    {
        return $this->peopleId;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getOrderIndex(): int
    {
        return $this->orderIndex;
    }
}