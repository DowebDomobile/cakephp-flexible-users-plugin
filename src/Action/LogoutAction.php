<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Action;

use Crud\Traits\RedirectTrait;

/**
 * Class LogoutAction
 * @package Dwdm\Users\Action
 */
class LogoutAction extends \CrudUsers\Action\LogoutAction
{
    protected function _post()
    {
        $this->_get();
    }
}