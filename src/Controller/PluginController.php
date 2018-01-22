<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller;

use App\Controller\AppController;
use Cake\Controller\Component\AuthComponent;
use Cake\Core\Configure;
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
        } else {
            $this->Crud->setConfig(['actions' => []]);
        }

        $config = Configure::read('Dwdm/Users.' . $this->name, [
            'components' => ['Dwdm/Users.Register', 'Dwdm/Users.Login'],
        ]);
        if (isset($config['components']) && is_array($config['components'])) {
            foreach ($config['components'] as $component => $config) {
                if (is_string($config)) {
                    $component = $config;
                    $config = [];
                }
                $this->loadComponent($component, $config);
            }
        }
    }
}
