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
        $id=$this?->getActor()?->getId();
        $avatarId=$this?->getActor()?->getAvatarId();
        $birthday=$this?->getActor()?->getBirthday();
        $deathday=$this?->getActor()?->getDeathday();
        $name=$this?->getActor()?->getName();
        $biography=$this?->getActor()?->getBiography();
        $placeOfBirth=$this?->getActor()?->getPlaceOfBirth();
        return <<<HTML
            <form action="{$action}" method="post">
                <input type="hidden" name="id" value="{$id}">
                <label for="birthday">
                    Date de naissance
                    <input type="date" name="birthday" value="{$this->escapeString($birthday)}">
                </label>
                <label for="deathday">
                    Date de décès
                    <input type="date" name="deathday" value="{$this->escapeString($deathday)}">
                </label>
                <label for="name">
                    Nom
                    <input type="text" name="name" value="{$this->escapeString($name)}">
                </label>
                <label for="biography">
                    Biographie
                    <input type="text" name="biography" value="{$this->escapeString($biography)}">
                </label>
                <label for="placeOfBirth">
                    Lieu de naissance
                    <input type="text" name="placeOfBirth" value="{$this->escapeString($placeOfBirth)}">
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
        $deathday=null;
        if (isset($_POST['deathday'])) {
            $deathday=$this->stripTagsAndTrim($_POST['deathday']);
        }
        if (!isset($_POST['birthday']) || !isset($_POST['name']) || !isset($_POST['biography']) || !isset($_POST['placeOfBirth'])) {
            throw new ParameterException('setEntityFromQueryString() - Missing parameter');
        }
        $birthday=$this->stripTagsAndTrim($_POST['birthday']);
        $name=$this->stripTagsAndTrim($_POST['name']);
        $biography=$this->stripTagsAndTrim($_POST['biography']);
        $placeOfBirth=$this->stripTagsAndTrim($_POST['placeOfBirth']);
        if (empty($birthday) || empty($name) || empty($biography) || empty($placeOfBirth)) {
            throw new ParameterException('setEntityFromQueryString() - Parameter is empty');
        }
        $this->actor=Actor::create($birthday, $name, $biography, $placeOfBirth, $deathday, $avatarId, $id);
    }
}