<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */
namespace Dwdm\Users\Controller;

use Cake\Controller\Component\AuthComponent;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Utility\Text;
use Dwdm\Users\Controller\Crud\CreateActionTrait;
use Dwdm\Users\Model\Table\UsersTable;
use Dwdm\Users\Model\Validation\UsersRegisterValidator;

/**
 * Users Controller
 */
class UsersController extends AppController
{
    use CreateActionTrait {
        create as register;
    }

    public function implementedEvents()
    {
        return [
                'Controller.initialize' => [
                    ['callable' => 'beforeFilter'],
                    [
                        'callable' => function (Event $event) {
                            /** @var UsersController $controller */
                            $controller = $event->getSubject();

                            $controller->Auth->allow(['register']);
                        }
                    ]
                ],
                'Controller.Users.register.before' => function (Event $event) {
                    /** @var UsersController $controller */
                    $controller = $event->getSubject();

                    /** @var UsersTable $Users */
                    $Users = $controller->loadModel();
                    $Users->setValidator('default', new UsersRegisterValidator());
                },
                'Controller.Users.register.beforeSave' => function (Event $event) {
                    /** @var UsersController $controller */
                    $controller = $event->getSubject();

                    $data = $controller->request->getData();
                    if (isset($data['email'])) {
                        $data['contacts'][] = [
                            'name' => 'email',
                            'replace' => $data['email'],
                            'token' => Text::uuid(),
                            'is_login' => true,
                        ];
                    }

                    return ['data' => $data,
                        'options' => [
                            'fields' => ['password', 'contacts'],
                            'associated' => ['UserContacts' => ['fields' => ['name', 'replace', 'token', 'is_login']]]
                        ]
                    ];
                },
                'Controller.Users.register.afterSave' => function (Event $event) {
                    /** @var UsersController $controller */
                    $controller = $event->getSubject();

                    $controller->Flash->success(__d('users', 'Registration success. Confirmation email was sent.'));
                    return $controller->redirect(['action' => 'index']);
                },
                'Controller.Users.register.afterFail' => function (Event $event) {
                    /** @var UsersController $controller */
                    $controller = $event->getSubject();
                    $controller->Flash->error(__d('users', 'Invalid registration data.'));
                },

                'Controller.Users.login.afterIdentify' => function (Event $event) {
                    /** @var UsersController $controller */
                    $controller = $event->getSubject();

                    $controller->Auth->setUser($event->getData('user'));
                    return $controller->redirect($controller->Auth->redirectUrl());
                },
                'Controller.Users.login.afterFail' => function (Event $event) {
                    /** @var UsersController $controller */
                    $controller = $event->getSubject();

                    $controller->Flash->error(__d('users', 'Username or password is incorrect'));
                },
                'Controller.Users.login.before' => function (Event $event) {
                    /** @var UsersController $controller */
                    $controller = $event->getSubject();

                    /** @var UsersTable $Users */
                    $Users = $controller->loadModel();
                    $Users->addBehavior('Dwdm/Users.EmailLogin');

                    /** @var AuthComponent $Auth */
                    $Auth = $controller->components()->get('Auth');
                    $Auth->getAuthenticate('Form')
                        ->setConfig(
                            ['finder' => 'user', 'fields' => ['username' => 'email'], 'userModel' => 'Dwdm/Users.Users'],
                            null,
                            true
                        );
                }
            ] + parent::implementedEvents();
    }

    /**
     * Login user.
     *
     * @return Response|null
     */
    public function login()
    {
        $result = $this->dispatchEvent($this->_eventName('before'), null, $this)->getResult();

        if ($this->request->is('post')) {
            if ($user = $this->Auth->identify()) {
                $result = $this->dispatchEvent($this->_eventName('afterIdentify'), compact('user'), $this)->getResult();
            } else {
                $result = $this->dispatchEvent($this->_eventName('afterFail'), null, $this)->getResult();
            }

            if ($result instanceof Response) {
                return $result;
            }
        }

        $result = $this->dispatchEvent($this->_eventName('after'), null, $this)->getResult();

        return ($result instanceof Response) ? $result : null;
    }
}
