<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller;

/**
 * Class UserContactsController
 * @package Dwdm\Users\Controller
 */
class UserContactsController extends PluginController
{
    /** {@inheritDoc} */
    protected $_defaultComponents = ['Dwdm/Users.ContactConfirm'];

    public function initialize()
    {
        parent::initialize();
    }
}