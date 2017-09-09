<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller;

use Cake\Event\Event;
use Dwdm\Users\Controller\Crud\UpdateActionTrait;
use Dwdm\Users\Model\Entity\UserContact;

/**
 * Class UserContactsController
 * @package Dwdm\Users\Controller
 */
class UserContactsController extends AppController
{
    use UpdateActionTrait {
        update as confirm;
    }

    public function implementedEvents()
    {
        return parent::implementedEvents() + [
                'Controller.UserContacts.confirm.before' => function (Event $event) {
                    /** @var UserContactsController $controller */
                    $controller = $event->getSubject();

                    $params = [];
                    if ($controller->request->is('get')) {
                        foreach (['token', 'id'] as $name) {
                            $params['UserContacts.' . $name] = $controller->request->getParam($name);
                        }
                    } elseif ($this->request->is(['post', 'put'])) {
                        $params = [
                            'UserContacts.name' => 'email',
                            'UserContacts.replace' => $this->request->getData('email'),
                            'UserContacts.token' => $this->request->getData('token'),
                        ];
                    }

                    /** @var UserContact $contact */
                    $contact = $controller->loadModel()->find('all', ['contain' => ['Users']])->where($params)->first();

                    if ($controller->request->is('get') && $contact) {
                        $controller->request = $controller->request->withMethod('POST');
                    }

                    if (!empty($params) && !$contact) {
                        $controller->request = $controller->request->withMethod('GET');
                        $controller->request->clearDetectorCache();
                        $controller->Flash->error(__d('users', 'Contact was not found.'));
                    }

                    return $contact ? : $controller->loadModel()->newEntity();
                },
                'Controller.UserContacts.confirm.beforeSave' => function(Event $event) {
                    /** @var UserContact $contact */
                    $contact = $event->getData('entity');

                    $contact->value = $contact->replace;
                    $contact->replace = null;
                    $contact->token = null;

                    if (null === $contact->user->is_active) {
                        $contact->user->is_active = true;
                        $contact->setDirty('user', true);
                    }

                    return $contact;
                },
                'Controller.UserContacts.confirm.afterSave' => function (Event $event) {
                    /** @var UsersController $controller */
                    $controller = $event->getSubject();

                    $controller->Flash->success(__d('users', 'Contact was confirmed. Please login.'));

                    return $controller->redirect(['controller' => 'Users', 'action' => 'login']);
                },
                'Controller.UserContacts.confirm.after' => function(Event $event) {
                    /** @var UserContactsController $controller */
                    $controller = $event->getSubject();

                    return $controller->loadModel()->newEntity();
                }
            ];
    }
}