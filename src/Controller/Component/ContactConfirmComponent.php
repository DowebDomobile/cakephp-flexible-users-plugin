<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use Dwdm\Users\Controller\PluginController;
use Dwdm\Users\Model\Entity\UserContact;

/**
 * ContactConfirm component
 */
class ContactConfirmComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'isAccessControlEnabled' => false,
        'successUrl' => ['controller' => 'Users', 'action' => 'login'],
    ];

    public function implementedEvents()
    {
        $initialize = $this->getConfig('isAccessControlEnabled') ? [] : ['Controller.initialize' => 'allowAccess'];
        return $initialize + [
                'Controller.UserContacts.confirm.before' => 'getContact',
                'Controller.UserContacts.confirm.beforeSave' => 'activateContact',
                'Controller.UserContacts.confirm.afterSave' => 'activationSuccess',
            ] + parent::implementedEvents();
    }

    /**
     * Allow access to public actions for non authorized user.
     *
     * @param Event $event
     */
    public function allowAccess(Event $event)
    {
        /** @var PluginController $controller */
        $controller = $event->getSubject();

        $controller->Auth->allow(['confirm']);
    }

    /**
     * Try to find contact by GET or POST data and return it or empty contact if not found.
     *
     * If contact found by GET data convert request to POST for confirm contact.
     * If contact not found by POST data convert request to GET and show confirm form with error message.
     *
     * @param Event $event
     * @return \Cake\Datasource\EntityInterface
     */
    public function getContact(Event $event) {
        /** @var PluginController $controller */
        $controller = $event->getSubject();

        $params = [];
        if ($controller->request->is('get')) {
            foreach (['token', 'id'] as $name) {
                $params['UserContacts.' . $name] = $controller->request->getParam($name);
            }
        } elseif ($controller->request->is(['post', 'put'])) {
            $params = [
                'UserContacts.name' => 'email',
                'UserContacts.replace' => $controller->request->getData('email'),
                'UserContacts.token' => $controller->request->getData('token'),
            ];
        }

        /** @var UserContact $contact */
        $contact = $controller->loadModel()->find('all', ['contain' => ['Users']])->where($params)->first();

        if ($controller->request->is('get') && $contact) {
            $controller->request = $controller->request->withMethod('POST');
        }

        if (!empty($params['UserContacts.token']) && !$contact) {
            $controller->request = $controller->request->withMethod('GET');
            $controller->request->clearDetectorCache();
            $controller->Flash->error(__d('users', 'Contact was not found.'));
        }

        return $contact ?: $controller->loadModel()->newEntity();
    }

    /**
     * Set new user contact to actual state.
     *
     * If user just newly registered and not already active, activate them.
     *
     * @param Event $event
     * @param UserContact $contact
     * @return UserContact
     */
    public function activateContact(Event $event, UserContact $contact) {
        $contact->value = $contact->replace;
        $contact->replace = null;
        $contact->token = null;

        if (null === $contact->user->is_active) {
            $contact->user->is_active = true;
            $contact->setDirty('user', true);
        }

        return $contact;
    }

    /**
     * Set success flash message and redirect to successUrl.
     *
     * @param Event $event
     * @return \Cake\Http\Response|null
     */
    public function activationSuccess(Event $event) {
        /** @var PluginController $controller */
        $controller = $event->getSubject();

        $controller->Flash->success(__d('users', 'Contact was confirmed. Please login.'));

        return $controller->redirect($this->getConfig('successUrl'));
    }
}
