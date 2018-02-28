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
    /** {@inheritDoc} */
    protected $_defaultComponents = ['Dwdm/Users.Register', 'Dwdm/Users.Login'];

    public function initialize()
    {
        parent::initialize();
    }
}
