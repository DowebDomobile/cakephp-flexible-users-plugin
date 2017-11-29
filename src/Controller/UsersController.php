<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */
namespace Dwdm\Users\Controller;

use Cake\Event\Event;
use Dwdm\Users\Controller\Action\LoginActionTrait;
use Dwdm\Users\Controller\Action\LogoutActionTrait;
use Dwdm\Users\Controller\Crud\CreateActionTrait;
use Dwdm\Users\Controller\Crud\CrudAwareTrait;
use Dwdm\Users\Controller\Crud\UpdateActionTrait;

/**
 * Users Controller
 */
class UsersController extends PluginController
{
    use CrudAwareTrait, LoginActionTrait, LogoutActionTrait, CreateActionTrait, UpdateActionTrait {
//        create as register;
        update as restore;
        update as confirm;
        update as edit;
    }

    public function beforeFilter(Event $event)
    {
        $this->Crud->mapAction('register', 'Crud.Add');
    }

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Dwdm/Users.Register');
        $this->loadComponent('Dwdm/Users.Login');
        $this->loadComponent('Dwdm/Users.Password');
    }
}
