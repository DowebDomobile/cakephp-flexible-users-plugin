<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller;

use Dwdm\Users\Controller\Crud\CrudAwareTrait;
use Dwdm\Users\Controller\Crud\UpdateActionTrait;

/**
 * Class UserContactsController
 * @package Dwdm\Users\Controller
 */
class UserContactsController extends PluginController
{
    use CrudAwareTrait, UpdateActionTrait {
        update as confirm;
    }

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Dwdm/Users.ContactConfirm');
    }
}