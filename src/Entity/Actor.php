<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class Actor
{
    private ?int $id;
    private int $avatarId;
    private string $birthday;
    private ?string $deathday;
    private string $name;
    private string $biography;
    private string $placeOfBirth;

    private function __construct()
    {
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAvatarId(): int
    {
        return $this->avatarId;
    }

    /**
     * @return string
     */
    public function getBirthday(): string
    {
        return $this->birthday;
    }

    /**
     * @return string|null
     */
    public function getDeathday(): ?string
    {
        return $this->deathday;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getBiography(): string
    {
        return $this->biography;
    }

    /**
     * @return string
     */
    public function getPlaceOfBirth(): string
    {
        return $this->placeOfBirth;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param int $avatarId
     */
    public function setAvatarId(int $avatarId): void
    {
        $this->avatarId = $avatarId;
    }

    /**
     * @param string $birthday
     */
    public function setBirthday(string $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @param string|null $deathday
     */
    public function setDeathday(?string $deathday): void
    {
        $this->deathday = $deathday;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $biography
     */
    public function setBiography(string $biography): void
    {
        $this->biography = $biography;
    }

    /**
     * @param string $placeOfBirth
     */
    public function setPlaceOfBirth(string $placeOfBirth): void
    {
        $this->placeOfBirth = $placeOfBirth;
    }

    public function delete(): Actor
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            DELETE FROM People
            WHERE id=:actorId
        SQL
        );
        $stmt->bindValue(':actorId', $this->getId(), PDO::PARAM_INT);
        $stmt->execute();
        $this->id=null;
        return $this;
    }

    protected function update(): Actor
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            UPDATE People
            SET avatarId=:avatarId
                birthday=:birthday,
                deathday=:deathday,
                name=:actorName,
                biography=:biography,
                placeOfBirth=:placeOfBirth
            WHERE id=:actorId
        SQL
        );
        $stmt->bindValue(':actorId', $this->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':avatarId', $this->getAvatarId(), PDO::PARAM_INT);
        $stmt->bindValue(':birthday', $this->getBirthday());
        $stmt->bindValue(':deathday', $this->getDeathday());
        $stmt->bindValue(':actorName', $this->getName());
        $stmt->bindValue(':biography', $this->getBiography());
        $stmt->bindValue(':placeOfBirth', $this->getPlaceOfBirth());
        $stmt->execute();
        return $this;
    }

    public static function create(string $birthday, string $name, string $biography, string $placeOfBirth, ?int $avatarId=null, ?string $deathday, ?int $id=null): Actor
    {
        $actor=new Actor();
        $actor->id=$id;
        $actor->avatarId=$avatarId;
        $actor->birthday=$birthday;
        $actor->deathday=$deathday;
        $actor->name=$name;
        $actor->biography=$biography;
        $actor->placeOfBirth=$placeOfBirth;
        return $actor;
    }

    protected function insert(): Actor
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            INSERT INTO Actor (avatarId, birthday, deathday, name, biography, placeOfBirth)
            VALUES (:avatarId, :birthday, :deathday, :name, :biography, :placeOfBirth)
        SQL
        );
        $stmt->bindValue(':avatarId', $this->getAvatarId(), PDO::PARAM_INT);
        $stmt->bindValue(':birthday', $this->getBirthday());
        $stmt->bindValue(':deathday', $this->getDeathday());
        $stmt->bindValue(':actorName', $this->getName());
        $stmt->bindValue(':biography', $this->getBiography());
        $stmt->bindValue(':placeOfBirth', $this->getPlaceOfBirth());        $stmt->execute();
        $this->setId((int)MyPdo::getInstance()->lastInsertId());
        return $this;
    }
}