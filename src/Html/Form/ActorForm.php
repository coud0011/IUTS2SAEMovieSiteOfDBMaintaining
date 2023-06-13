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
}