<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\Actor;
use Exception\ParameterException;
use Html\StringEscaper;

class ActorForm
{
    use StringEscaper;
    private ?Actor $actor;

    /**
     * @param Actor|null $actor
     */
    public function __construct(?Actor $actor=null)
    {
        $this->actor = $actor;
    }

    /**
     * @return Actor|null
     */
    public function getActor(): ?Actor
    {
        return $this->actor;
    }

    /**
     * @param string $action
     * @return string
     */
    public function getHtmlForm(string $action): string
    {
        return <<<HTML
            <form action="{$action}" method="post">
                <input type="hidden" name="id" value="{$this?->getActor()?->getId()}">
                <input type="hidden" name="avatarId" value="{$this?->getActor()?->getAvatarId()}">
                <label for="birthday">
                    Date de naissance
                    <input type="date" name="birthday" value="{$this->escapeString($this?->getActor()?->getBirthday())}">
                </label>
                <label for="deathday">
                    Date de décès
                    <input type="date" name="deathday" value="{$this->escapeString($this?->getActor()?->getDeathday())}">
                </label>
                <label for="name">
                    Nom
                    <input type="text" name="name" value="{$this->escapeString($this?->getActor()?->getName())}" required>
                </label>
                <label for="biography">
                    Biographie
                    <input type="text" name="biography" value="{$this->escapeString($this?->getActor()?->getBiography())}">
                </label>
                <label for="placeOfBirth">
                    Lieu de naissance
                    <input type="text" name="placeOfBirth" value="{$this->escapeString($this?->getActor()?->getPlaceOfBirth())}">
                </label>
                <input type="submit" value="Enregistrer">
            </form>
        HTML;
    }

    /**
     * @return void
     * @throws ParameterException
     */
    public function setEntityFromQueryString(): void
    {
        $id=null;
        if (isset($_POST['id']) && ctype_digit($_POST['id'])) {
            $id=(int)$_POST['id'];
        }
        $avatarId=null;
        if (isset($_POST['avatarId']) && ctype_digit($_POST['avatarId'])) {
            $avatarId=(int)$_POST['avatarId'];
        }
        $birthday=null;
        if (!empty($_POST['birthday'])) {
            $birthday=$this->stripTagsAndTrim($_POST['birthday']);
        }
        $deathday=null;
        if (!empty($_POST['deathday'])) {
            $deathday=$this->stripTagsAndTrim($_POST['deathday']);
        }
        if (empty($_POST['name']) || !isset($_POST['biography']) || !isset($_POST['placeOfBirth'])) {
            throw new ParameterException('setEntityFromQueryString() - Missing parameter');
        }
        $name=$this->stripTagsAndTrim($_POST['name']);
        $biography=$this->stripTagsAndTrim($_POST['biography']);
        $placeOfBirth=$this->stripTagsAndTrim($_POST['placeOfBirth']);
        $this->actor=Actor::create($name, $biography, $placeOfBirth, $birthday, $deathday, $avatarId, $id);
    }
}
