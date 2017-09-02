<?php
namespace Dwdm\Users\Controller;

use Cake\Http\Response;
use Dwdm\Users\Model\Entity\User;

/**
 * Users Controller
 *
 * @property \Dwdm\Users\Model\Table\UsersTable $Users
 *
 * @method \Dwdm\Users\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['UserContacts']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

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
                $this->Users->patchEntity($user, $data, $options);
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

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
