<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Component;

use Cake\Event\Event;
use Cake\ORM\Table;
use Cake\Utility\Text;
use Dwdm\Users\Controller\PluginController;
use Dwdm\Users\Model\Entity\User;

/**
 * Password component
 */
class PasswordComponent extends AbstractAccessComponent
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'publicActions' => ['restore', 'confirm'],
        'successUrl' => ['action' => 'confirm'],
        'behavior' => [
            'className' => 'Dwdm/Users.Login',
            'options' => [],
        ]
    ];

    /**
     * {@inheritdoc}
     */
    public function implementedEvents()
    {
        return [
                'Controller.Users.restore.before' => 'getRestoringUser',
                'Controller.Users.restore.beforeSave' => 'createToken',
                'Controller.Users.restore.afterSave' => 'redirect',
                'Controller.Users.confirm.before' => 'getConfirmingUser',
            ] + parent::implementedEvents();
    }

    /**
     * Try to find user entity and return it if not found return new empty entity.
     *
     * @param Event $event
     * @return \Cake\Datasource\EntityInterface
     */
    public function getRestoringUser(Event $event)
    {
        /** @var PluginController $controller */
        $controller = $event->getSubject();

        /** @var Table $Users */
        $Users = $controller->loadModel();

        $user = null;
        if ($controller->request->is('post')) {
            $Users->addBehavior($this->getConfig('behavior.className'), $this->getConfig('behavior.options'));
            $user = $Users->find('user', ['username' => $controller->request->getData('email')])->first();

            if (!$user) {
                $controller->Flash->error(__d('users', 'User not found.'));
                $controller->request = $controller->request->withMethod('GET');
                $controller->request->clearDetectorCache();
            }
        }

        return $user ? : $Users->newEntity();
    }

    public function getConfirmingUser(Event $event)
    {
        /** @var PluginController $controller */
        $controller = $event->getSubject();

        /** @var Table $Users */
        $Users = $controller->loadModel();

        return $Users->newEntity();
    }

    /**
     * Set restore password confirmation token.
     *
     * @param Event $event
     * @param User $user
     * @return User
     */
    public function createToken(Event $event, User $user)
    {
        $user->token = Text::uuid();

        return $user;
    }

    /**
     * Set success message and redirect to successUrl page.
     *
     * @param Event $event
     * @return \Cake\Http\Response|null
     */
    public function redirect(Event $event)
    {
        /** @var PluginController $controller */
        $controller = $event->getSubject();

        $controller->Flash->success(__d('users', 'Restore password confirmation was sent.'));

        return $controller->redirect($this->getConfig('successUrl'));
    }
}
