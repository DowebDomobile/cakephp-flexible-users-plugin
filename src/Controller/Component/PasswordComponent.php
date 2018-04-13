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
use Dwdm\Users\Validation\PasswordConfirmValidator;

/**
 * Password component
 */
class PasswordComponent extends AbstractComponent
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'actions' => [
            'restore' => [
                'className' => 'CrudUsers.ForgotPassword',
                'findMethod' => 'User',
                'messages' => ['error' => ['text' => 'User not found.']],
                'listeners' => [
                    'Crud.beforeForgotPassword' => [
                        ['callable' => 'configureModel'],
                        ['callable' => 'configureFindOptions'],
                    ],
                    'Crud.afterForgotPassword' => 'createToken',
                ],
            ],
            'confirm' => [
                'className' => 'CrudUsers.ResetPassword',
                'tokenField' => 'token',
                'saveOptions' => ['fields' => ['password']],
                'listeners' => [
                    'Crud.beforeFilter' => 'configureValidator',
                    'Crud.beforeRender' => 'publishToken',
                    'Crud.verifyToken' => 'verifyToken',
                    'Crud.beforeSave' => 'updateEntity',
                    'Crud.afterSave' => 'resetWrongData',
                ],
            ],
        ],
        'publicActions' => ['restore', 'confirm'],
        'successUrl' => ['action' => 'confirm'],
        'userModel' => 'Dwdm/Users.Users',
        'username' => 'email',
        'behavior' => [
            'className' => 'Dwdm/Users.Login',
            'options' => [],
        ]
    ];

    /**
     * Add behavior to model.
     */
    public function configureModel()
    {
        /** @var PluginController $controller */
        $controller = $this->getController();

        /** @var Table $Users */
        $Users = $controller->loadModel($this->getConfig('userModel'));
        $Users->addBehavior($this->getConfig('behavior.className'), $this->getConfig('behavior.options'));
    }

    /**
     * @param Event $event
     */
    public function configureFindOptions(Event $event)
    {
        $subject = $event->getSubject();

        $subject->set(
            ['findConfig' => ['username' => $subject->findConfig['conditions'][$this->getConfig('username')]]]
        );
    }

    /**
     * Set restore password confirmation token.
     *
     * @param Event $event
     */
    public function createToken(Event $event)
    {
        $subject = $event->getSubject();

        if ($subject->success) {
            $subject->entity->token = Text::uuid();
            $this->getController()->loadModel()->save($subject->entity);
        }
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

    public function publishToken(Event $event)
    {
        $subject = $event->getSubject();
        $subject->set(['token' => isset($subject->token) ? $subject->token : null]);
        $this->getController()->set('token', $subject->token);
    }

    public function configureValidator()
    {
        /** @var PluginController $controller */
        $controller = $this->getController();

        /** @var Table $Users */
        $Users = $controller->loadModel($this->getConfig('userModel'));
        $Users->setValidator($Users::DEFAULT_VALIDATOR, new PasswordConfirmValidator());
    }

    public function verifyToken(Event $event)
    {
        $subject = $event->getSubject();
        $subject->set(['verified' => true]);
        $subject->set(['entity' => $subject->entity ? : $this->getController()->loadModel()->newEntity()]);
    }

    public function updateEntity(Event $event)
    {
        $subject = $event->getSubject();

        /** @var User $entity */
        $entity = $subject->entity;

        if (!$entity->getErrors()) {
            $entity->token = null;
        }
    }

    public function resetWrongData(Event $event)
    {
        $subject = $event->getSubject();

        /** @var User $entity */
        $entity = $subject->entity;

        if ($entity->getErrors()) {
            $entity->password = null;
            $request = $this->getController()->request;
            $this->getController()->request = $request->withData('password', null)->withData('verify', null);
        }
    }
}
