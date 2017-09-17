<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Action;

use Cake\Controller\Component\AuthComponent;
use Cake\Network\Request;

/**
 * Trait LogoutActionTrait
 * @package Dwdm\Users\Controller\Action
 *
 * @property AuthComponent $Auth
 * @property Request $request
 */
trait LogoutActionTrait
{
    public function logout()
    {
        $this->request->allowMethod('post');

        $this->Auth->logout();
    }
}