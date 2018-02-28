<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Component;

use Cake\Controller\Component\AuthComponent;
use Cake\Event\Event;
use Cake\ORM\Table;
use Dwdm\Users\Controller\PluginController;

/**
 * Login component
 */
class LoginComponent extends AbstractComponent
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'actions' => [
            'login' => [
                'className' => 'CrudUsers.Login',
                'listeners' => [],
            ], 'logout' => 'Dwdm/Users.Logout'],
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

    public function initialize(array $config)
    {
        parent::initialize($config);

        $listeners = $this->getConfig('actions.login.listeners');
        $model = ['callable' => 'configureModel'];
        if (is_array($listeners) && empty($listeners)) {
            $this->setConfig('actions.login.listeners', [
                'Crud.beforeLogin' => is_array($this->getConfig('authenticate')) ?
                    [$model, ['callable' => 'configureAuth']] : [$model],
            ]);
        }
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
        $Users = $controller->loadModel($this->getConfig('authenticate.userModel'));
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
