<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Component;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\Table;
use Cake\Utility\Text;
use Crud\Event\Subject;
use Dwdm\Users\Controller\PluginController;
use Dwdm\Users\Validation\UsersRegisterValidator;

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
        'action' => 'register',
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
        /** @var Controller $controller */
        $controller = $this->getController();

        $listeners = [];
        if ($this->getConfig('action') == $controller->request->getParam('action')) {
            $listeners = [
                'Crud.beforeFilter' => [
                    ['callable' => 'setValidator'],
                    ['callable' => 'setSaveOptions'],
                    ['callable' => 'modifyRequest'],
                ],
                'Crud.setFlash' => 'setFlash',
                'Crud.beforeRedirect' => 'redirect',
            ];
        }

        return $listeners + parent::implementedEvents();
    }

    /**
     * Set register form validator from config.
     *
     * @param Event $event
     */
    public function setValidator(Event $event)
    {
        $validatorClassName = $this->getConfig('validatorClassName');

        /** @var Table $Users */
        $Users = $this->getController()->loadModel();
        $Users->setValidator('default', new $validatorClassName);
    }

    /**
     * Set save options to CRUD.
     *
     * @param Event $event
     */
    public function setSaveOptions(Event $event)
    {
        /** @var PluginController $controller */
        $controller = $this->getController();
        $controller->Crud->setConfig('actions', ['register' => ['saveOptions' => $this->getConfig('user.saveOptions')]]);
    }

    /**
     * Prepare request data from for save.
     *
     * @param Event $event
     */
    public function modifyRequest(Event $event)
    {
        $callback = $this->getConfig('user.prepareDataCallback');
        if ($callback && is_callable($callback)) {
            /** @var PluginController $controller */
            $controller = $this->getController();
            $request = $controller->request;

            $data = call_user_func($callback, $request->getData());

            foreach ($data as $key => $value) {
                $request = $request->withData($key, $value);
            }

            $controller->request = $request;
        }
    }

    /**
     * Set flash message.
     *
     * @param Event $event
     */
    public function setFlash(Event $event)
    {
        /** @var Subject $subject */
        $subject = $event->getSubject();
        $subject->set(['text' => $subject->created ?
            __d('users', 'Registration success. Confirmation message was sent.') :
            __d('users', 'Registration error.')
        ]);
    }

    /**
     * Set redirect url.
     *
     * @param Event $event
     */
    public function redirect(Event $event)
    {
        /** @var Subject $subject */
        $subject = $event->getSubject();
        $subject->set(['url' => $this->getConfig('successUrl')]);
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
