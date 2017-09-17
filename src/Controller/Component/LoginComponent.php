<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Component\AuthComponent;
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
        $model = ['callable' => 'configureModel'];
        $auth = ['callable' => 'configureAuth'];

        return [
                'Controller.Users.login.before' => is_array($this->getConfig('authenticate'))
                    ? [$model, $auth] : [$model],
                'Controller.Users.login.afterIdentify' => 'afterIdentify',
                'Controller.Users.login.afterFail' => 'sendError',
            ] + parent::implementedEvents();
    }

    /**
     * Add behavior to model.
     *
     * @param Event $event
     */
    public function configureModel(Event $event)
    {
        /** @var PluginController $controller */
        $controller = $event->getSubject();

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
        $controller = $event->getSubject();

        /** @var AuthComponent $Auth */
        $Auth = $controller->components()->get('Auth');
        $Auth->getAuthenticate('Form')->setConfig($this->getConfig('authenticate'), null, true);
    }

    /**
     * Set authorized user and redirect to auth redirect url.
     *
     * @param Event $event
     * @return \Cake\Http\Response|null
     */
    public function afterIdentify(Event $event) {
        /** @var PluginController $controller */
        $controller = $event->getSubject();

        $controller->Auth->setUser($event->getData('user'));
        return $controller->redirect($controller->Auth->redirectUrl());
    }

    /**
     * Show flash error message.
     *
     * @param Event $event
     */
    public function sendError(Event $event)
    {
        /** @var PluginController $controller */
        $controller = $event->getSubject();

        $controller->Flash->error(__d('users', 'Username or password is incorrect'));
    }
}
