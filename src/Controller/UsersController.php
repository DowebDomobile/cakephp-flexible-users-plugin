<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */
namespace Dwdm\Users\Controller;

use Cake\Event\Event;
use Dwdm\Users\Controller\Action\LoginAction;
use Dwdm\Users\Controller\Action\LogoutActionTrait;
use Dwdm\Users\Controller\Crud\CrudAwareTrait;
use Dwdm\Users\Controller\Crud\UpdateActionTrait;

/**
 * Users Controller
 */
class UsersController extends PluginController
{
    use CrudAwareTrait, LogoutActionTrait, UpdateActionTrait {
        update as restore;
        update as confirm;
        update as edit;
    }

    public function beforeFilter(Event $event)
    {
        $this->Crud->mapAction('register', 'Crud.Add');
        $this->Crud->mapAction('login', LoginAction::class);
    }

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Dwdm/Users.Register');
        $this->loadComponent('Dwdm/Users.Login');
        $this->loadComponent('Dwdm/Users.Password');
    }
}
