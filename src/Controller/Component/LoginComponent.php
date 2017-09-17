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
        'behaviorClassName' => 'Dwdm/Users.EmailLogin',
    ];

    public function implementedEvents()
    {
        $model = ['callable' => 'configureModel'];
        $auth = ['callable' => 'configureAuth'];

        return [
                'Controller.Users.login.before' => $this->getConfig('authenticate') === null
                    ? [$model] : [$model, $auth],
                'Controller.Users.login.afterIdentify' => 'afterIdentify',
                'Controller.Users.login.afterFail' => 'sendError',
            ] + parent::implementedEvents();
    }

    public function configureModel(Event $event)
    {
        /** @var PluginController $controller */
        $controller = $event->getSubject();

        /** @var Table $Users */
        $Users = $controller->loadModel();
        $Users->addBehavior($this->getConfig('behaviorClassName'));
    }

    public function configureAuth(Event $event)
    {
        /** @var PluginController $controller */
        $controller = $event->getSubject();

        /** @var AuthComponent $Auth */
        $Auth = $controller->components()->get('Auth');
        $Auth->getAuthenticate('Form')->setConfig($this->getConfig('authenticate'), null, true);
    }

    public function afterIdentify(Event $event) {
        /** @var PluginController $controller */
        $controller = $event->getSubject();

        $controller->Auth->setUser($event->getData('user'));
        return $controller->redirect($controller->Auth->redirectUrl());
    }

    public function sendError(Event $event)
    {
        /** @var PluginController $controller */
        $controller = $event->getSubject();

        $controller->Flash->error(__d('users', 'Username or password is incorrect'));
    }
}
