<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Exception\EntityNotFoundException;
use PDO;

class Actor
{
    private ?int $id;
    private ?int $avatarId;
    private ?string $birthday;
    private ?string $deathday;
    private string $name;
    private string $biography;
    private string $placeOfBirth;

    private function __construct()
    {
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getAvatarId(): ?int
    {
        return $this->avatarId;
    }

    /**
     * @return string|null
     */
    public function getBirthday(): ?string
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
     * @param int|null $avatarId
     */
    public function setAvatarId(?int $avatarId): void
    {
        $this->avatarId = $avatarId;
    }

    /**
     * @param string|null $birthday
     */
    public function setBirthday(?string $birthday): void
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

    /**
     * Supprime un acteur par rapport à l'id de l'objet courant
     * @return $this
     */
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

    /**
     * Met à jour un acteur par rapport à l'id de l'objet courant
     * @return $this
     */
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

    /**
     * Crée une instance de la classe Actor
     * @param string $birthday
     * @param string $name
     * @param string $biography
     * @param string $placeOfBirth
     * @param int|null $avatarId
     * @param string|null $deathday
     * @param int|null $id
     * @return Actor
     */
    public static function create(string $birthday, string $name, string $biography, string $placeOfBirth, ?string $deathday=null, ?int $avatarId=null, ?int $id=null): Actor
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

    /**
     * Insère un acteur dans la base de données par rapport à l'objet courant
     * @return $this
     */
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

    /**
     * @return $this
     */
    public function save(): Actor
    {
        if ($this->getId()) {
            $this->update();
        } else {
            $this->insert();
        }
        return $this;
    }

    /**
     * Retourne un acteur par rapport à l'id en paramètre
     * @param int $id
     * @return Actor
     */
    public static function findById(int $id): Actor
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM People
            WHERE id=:actorId
        SQL
        );
        $stmt->bindParam(':actorId', $id, PDO::PARAM_INT);
        $stmt->execute();
        $actor=$stmt->fetchObject(Actor::class);
        if (!$actor) {
            throw new EntityNotFoundException("findById() - Actor not found");
        }
        return $actor;
    }
}