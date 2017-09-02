<?php
namespace Dwdm\Users\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property |\Cake\ORM\Association\HasMany $UserAttributes
 * @property \Dwdm\Users\Model\Table\UserContactsTable|\Cake\ORM\Association\HasMany $UserContacts
 *
 * @method \Dwdm\Users\Model\Entity\User get($primaryKey, $options = [])
 * @method \Dwdm\Users\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \Dwdm\Users\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \Dwdm\Users\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Dwdm\Users\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Dwdm\Users\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \Dwdm\Users\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('UserAttributes', [
            'foreignKey' => 'user_id',
            'className' => 'Dwdm/Users.UserAttributes'
        ]);
        $this->hasMany('UserContacts', [
            'foreignKey' => 'user_id',
            'className' => 'Dwdm/Users.UserContacts'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('password')
            ->allowEmpty('password');

        $validator
            ->dateTime('registered')
            ->requirePresence('registered', 'create')
            ->notEmpty('registered');

        $validator
            ->scalar('token')
            ->allowEmpty('token');

        $validator
            ->dateTime('expiration')
            ->allowEmpty('expiration');

        return $validator;
    }
}
