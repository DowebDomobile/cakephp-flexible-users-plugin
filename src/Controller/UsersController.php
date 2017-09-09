<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */
namespace Dwdm\Users\Controller;

use Cake\Event\Event;
use Cake\Utility\Text;
use Dwdm\Users\Controller\Crud\CreateActionTrait;

/**
 * Users Controller
 *
 * @property \Dwdm\Users\Model\Table\UsersTable $Users
 *
 * @method \Dwdm\Users\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    use CreateActionTrait {
        create as register;
    }

    public function implementedEvents()
    {
        return parent::implementedEvents() + [
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
                }
            ];
    }


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
