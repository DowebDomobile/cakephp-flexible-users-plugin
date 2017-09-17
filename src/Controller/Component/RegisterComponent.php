<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Component;

use Cake\Event\Event;
use Cake\ORM\Table;
use Cake\Utility\Text;
use Dwdm\Users\Controller\PluginController;
use Dwdm\Users\Model\Validation\UsersRegisterValidator;

/**
 * Class RegisterComponent
 * @package Dwdm\Users\Controller\Component
 */
class RegisterComponent extends AbstractAccessComponent
{

    /**
     * Default configuration.
     *
     * `isAccessControlEnabled` set this to true if any type of access control used in your application. Default: false
     *
     * @var array
     */
    protected $_defaultConfig = [
        'publicActions' => ['register'],
        'validatorClassName' => UsersRegisterValidator::class,
        'user' => [
            'prepareDataCallback' => null,
            'saveOptions' => [
                'fields' => ['password', 'contacts'],
                'associated' => ['UserContacts' => ['fields' => ['name', 'replace', 'token', 'is_login']]]
            ],
        ],
        'successUrl' => ['controller' => 'UserContacts', 'action' => 'confirm'],
    ];

    /**
     * {@inheritdoc}
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        if (null === $this->getConfig('user.prepareDataCallback'))  {
            $this->setConfig('user.prepareDataCallback', [$this, '_prepareData']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function implementedEvents()
    {
        return [
                'Controller.Users.register.before' => 'setValidator',
                'Controller.Users.register.beforeSave' => 'createUserEntity',
                'Controller.Users.register.afterSave' => 'registrationSuccess',
                'Controller.Users.register.afterFail' => 'registrationFail',
            ] + parent::implementedEvents();
    }

    /**
     * Set register form validator from config.
     *
     * @param Event $event
     */
    public function setValidator(Event $event)
    {
        /** @var PluginController $controller */
        $controller = $event->getSubject();

        $validatorClassName = $this->getConfig('validatorClassName');

        /** @var Table $Users */
        $Users = $controller->loadModel();
        $Users->setValidator('default', new $validatorClassName);
    }

    /**
     * Create user entity data for save entity.
     *
     * @param Event $event
     * @return array
     */
    public function createUserEntity(Event $event) {
        /** @var PluginController $controller */
        $controller = $event->getSubject();

        $callback = $this->getConfig('user.prepareDataCallback');
        $data = $controller->request->getData();
        $data = is_callable($callback) ? call_user_func($callback, $data) : $data;

        $options = $this->getConfig('user.saveOptions');

        return compact('data', 'options');
    }

    /**
     * Set success flash message and redirect to successUrl.
     *
     * @param Event $event
     * @return \Cake\Http\Response|null
     */
    public function registrationSuccess(Event $event)
    {
        /** @var PluginController $controller */
        $controller = $event->getSubject();

        $controller->Flash->success(__d('users', 'Registration success. Confirmation message was sent.'));
        return $controller->redirect($this->getConfig('successUrl'));
    }

    /**
     * Set error flash message.
     *
     * @param Event $event
     */
    public function registrationFail(Event $event)
    {
        /** @var PluginController $controller */
        $controller = $event->getSubject();
        $controller->Flash->error(__d('users', 'Invalid registration data.'));
    }

    /**
     * Default prepare data callback.
     *
     * Add contact entity data to user entity data.
     *
     * @param array $data
     * @return array
     */
    protected function _prepareData(array $data = [])
    {
        if (isset($data['email'])) {
            $data['contacts'][] = [
                'name' => 'email',
                'replace' => $data['email'],
                'token' => Text::uuid(),
                'is_login' => true,
            ];
        }

        return $data;
    }
}
