<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller;

use App\Controller\AppController;

abstract class PluginController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        if (!$this->components()->has('Auth')) {
            $this->loadComponent(
                'Auth',
                ['loginAction' => ['plugin' => 'Dwdm/Users', 'controller' => 'Users', 'action' => 'login']]
            );
        }
    }

}
