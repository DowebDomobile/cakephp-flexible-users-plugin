<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */
namespace Dwdm\Users\Controller;

use Cake\Event\Event;

/**
 * Users Controller
 */
class UsersController extends PluginController
{
    public function beforeFilter(Event $event)
    {
        $this->Crud->mapAction('register', 'Crud.Add');
        $this->Crud->mapAction('login', 'CrudUsers.Login');
        $this->Crud->mapAction('logout', 'Dwdm/Users.Logout');
    }

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Dwdm/Users.Register');
        $this->loadComponent('Dwdm/Users.Login');
    }
}
