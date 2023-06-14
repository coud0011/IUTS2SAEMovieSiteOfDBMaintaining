<?php

namespace Tests;

use Codeception\Exception\ModuleException;
use Database\MyPdo;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class CrudTester extends \Codeception\Actor
{
    use _generated\CrudTesterActions;

    /**
     * Define custom actions here
     */
    public function _initialize($settings = []): void
    {
        try {
            MyPdo::setConfiguration($this->getModule('Db')->_getConfig('dsn'));
        } catch (ModuleException $moduleException) {
            $this->fail('Codeception DB module not found');
        }
    }
}
