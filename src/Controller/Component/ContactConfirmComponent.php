<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Component;

use Cake\Event\Event;
use Cake\ORM\Query;
use Crud\Event\Subject;
use Dwdm\Users\Model\Entity\UserContact;
use Dwdm\Users\Model\Table\UserContactsTable;

/**
 * ContactConfirm component
 */
class ContactConfirmComponent extends AbstractComponent
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'actions' => [
            'confirm' => [
                'className' => 'Crud.Edit',
                'listeners' => [
                    'Crud.beforeFind' => 'updateQuery',
                    'Crud.afterFind' => 'confirmContact'
                ],
            ]
        ],
        'publicActions' => ['confirm'],
        'successUrl' => ['controller' => 'Users', 'action' => 'login'],
    ];

    public function updateQuery(Event $event)
    {
        /** @var Subject $subject */
        $subject = $event->getSubject();
        $token = $this->_getToken();

        /** @var Query $query */
        $query = $subject->query;

        if ($this->getController()->request->is(['post', 'patch', 'put'])) {
            $replace = $this->getController()->request->getData('replace');
            $query->contain(['Users'])
                ->where(['UserContacts.replace' => $replace, 'UserContacts.token' => $token]);
        } elseif ($token) {
            $query->contain(['Users'])->andWhere(['UserContacts.token' => $token]);
        }
    }

    public function confirmContact(Event $event)
    {
        /** @var UserContact $entity */
        $entity = $event->getSubject()->entity;
        if (($token = $this->_getToken()) && ($entity->token == $token)) {
            $entity->value = $entity->replace;
            $entity->replace = null;
            $entity->token = null;

            if (null === $entity->user->is_active) {
                $entity->user->is_active = true;
                $entity->setDirty('user', true);
            }

            /** @var UserContactsTable $Model */
            $Model = $event->getSubject()->repository;
            $Model->save($entity);

            return $this->getController()->redirect($this->getConfig('successUrl'));
        }

    }

    protected function _getToken()
    {
        $request = $this->getController()->request;
        return $request->getParam('token') ? : $request->getData('token', false);
    }
}
