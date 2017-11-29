<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller;

use App\Controller\AppController;
use Cake\Controller\Component\AuthComponent;
use Crud\Controller\Component\CrudComponent;
use Crud\Controller\ControllerTrait;

/**
 * Class PluginController
 * @package Dwdm\Users\Controller
 *
 * @property AuthComponent $Auth
 * @property CrudComponent $Crud
 */
abstract class PluginController extends AppController
{
    use ControllerTrait;

    public function initialize()
    {
        parent::initialize();

        if (!$this->components()->has('Auth')) {
            $this->loadComponent(
                'Auth',
                ['loginAction' => ['plugin' => 'Dwdm/Users', 'controller' => 'Users', 'action' => 'login']]
            );
        }

        if (!$this->components()->has('Crud')) {
            $this->loadComponent('Crud.Crud', ['actions' => []]);
        }
    }
}
