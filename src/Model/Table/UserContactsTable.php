<?php
namespace Dwdm\Users\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserContacts Model
 *
 * @property \Dwdm\Users\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Dwdm\Users\Model\Entity\UserContact get($primaryKey, $options = [])
 * @method \Dwdm\Users\Model\Entity\UserContact newEntity($data = null, array $options = [])
 * @method \Dwdm\Users\Model\Entity\UserContact[] newEntities(array $data, array $options = [])
 * @method \Dwdm\Users\Model\Entity\UserContact|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Dwdm\Users\Model\Entity\UserContact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Dwdm\Users\Model\Entity\UserContact[] patchEntities($entities, array $data, array $options = [])
 * @method \Dwdm\Users\Model\Entity\UserContact findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserContactsTable extends Table
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

        $this->setTable('user_contacts');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Dwdm/Users.Users'
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
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('value')
            ->allowEmpty('value');

        $validator
            ->scalar('replace')
            ->allowEmpty('replace');

        $validator
            ->boolean('is_login')
            ->requirePresence('is_login', 'create')
            ->notEmpty('is_login');

        $validator
            ->scalar('token')
            ->allowEmpty('token');

        $validator
            ->dateTime('expiration')
            ->allowEmpty('expiration');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
