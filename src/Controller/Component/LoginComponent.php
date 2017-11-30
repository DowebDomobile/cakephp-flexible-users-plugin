<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Component\AuthComponent;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\Table;
use Dwdm\Users\Controller\PluginController;

/**
 * Login component
 */
class LoginComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'authenticate' => [
            'finder' => 'user',
            'fields' => ['username' => 'email'],
            'userModel' => 'Dwdm/Users.Users'
        ],
        'behavior' => [
            'className' => 'Dwdm/Users.Login',
            'options' => []
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function implementedEvents()
    {
        /** @var Controller $controller */
        $controller = $this->getController();

        $listeners = [];
        if ('login' == $controller->request->getParam('action')) {
            $model = ['callable' => 'configureModel'];
            $auth = ['callable' => 'configureAuth'];

            $listeners = [
                'Crud.beforeLogin' => is_array($this->getConfig('authenticate')) ? [$model, $auth] : [$model],
            ];
        }

        return $listeners + parent::implementedEvents();
    }

    /**
     * Add behavior to model.
     *
     * @param Event $event
     */
    public function configureModel(Event $event)
    {
        /** @var PluginController $controller */
        $controller = $this->getController();

        /** @var Table $Users */
        $Users = $controller->loadModel();
        $Users->addBehavior($this->getConfig('behavior.className'), $this->getConfig('behavior.options'));
    }

    /**
     * Set config for FormAuthenticate object.
     *
     * @param Event $event
     */
    public function configureAuth(Event $event)
    {
        /** @var PluginController $controller */
        $controller = $this->getController();

        /** @var AuthComponent $Auth */
        $Auth = $controller->components()->get('Auth');
        $Auth->getAuthenticate('Form')->setConfig($this->getConfig('authenticate'), null, true);
    }
}
