<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Users;

use Cake\Controller\Component\FlashComponent;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Network\Request;
use Dwdm\Users\Model\Entity\User;
use Dwdm\Users\Model\Table\UsersTable;


/**
 * Trait AddActionTrait
 *
 * @package Dwdm\Users\Controller\Users
 *
 * @property Request $request
 * @property UsersTable $Users
 * @property FlashComponent $Flash
 *
 * @method Event dispatchEvent($name, $data = null, $subject = null)
 */
trait AddActionTrait
{
    /**
     * Add user
     *
     * @return \Cake\Http\Response|null
     */
    public function add()
    {
        $result = $this->dispatchEvent('Controller.Users.add.before', null, $this)->getResult();

        if ($result instanceof Response) {
            return $result;
        }

        $user = $result instanceof User ? $result : $this->Users->newEntity();

        if ($this->request->is('post')) {
            $result = $this->dispatchEvent('Controller.Users.add.beforeSave', compact('user'), $this)->getResult();

            if ($result instanceof User) {
                $user = $result;
            } else {
                $data = is_array($result) && isset($result['data']) ? $result['data'] : $this->request->getData();
                $options = is_array($result) && isset($result['options']) ? $result['options'] : [];
                $user = $this->Users->patchEntity($user, $data, $options);
            }

            if ($this->Users->save($user)) {
                $this->Flash->success(__d('users', 'The user has been saved.'));

                $result = $this->dispatchEvent('Controller.Users.add.afterSave', compact('user'), $this)->getResult();

                if ($result instanceof Response) {
                    return $result;
                }
            } else {
                $this->Flash->error(__d('users', 'The user could not be saved. Please, try again.'));

                $result = $this->dispatchEvent('Controller.Users.add.afterFail', compact('user'), $this)->getResult();

                if ($result instanceof Response) {
                    return $result;
                }
            }
        }

        $result = $this->dispatchEvent('Controller.Users.add.after', compact('user'), $this)->getResult();

        $user = $result instanceof User ? $result : $user;

        $this->set(compact('user'));
        $this->set('_serialize', ['user']);

        return null;
    }
}