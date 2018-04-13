<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */
namespace Dwdm\Users\Controller;

/**
 * Users Controller
 */
class UsersController extends PluginController
{
    /** {@inheritDoc} */
    protected $_defaultComponents = ['Dwdm/Users.Register', 'Dwdm/Users.Login', 'Dwdm/Users.Password'];

    public function initialize()
    {
        parent::initialize();
    }
}
