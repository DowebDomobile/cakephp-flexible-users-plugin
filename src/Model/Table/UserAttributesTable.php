<?php
namespace Dwdm\Users\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserAttributes Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Dwdm\Users\Model\Entity\UserAttribute get($primaryKey, $options = [])
 * @method \Dwdm\Users\Model\Entity\UserAttribute newEntity($data = null, array $options = [])
 * @method \Dwdm\Users\Model\Entity\UserAttribute[] newEntities(array $data, array $options = [])
 * @method \Dwdm\Users\Model\Entity\UserAttribute|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Dwdm\Users\Model\Entity\UserAttribute patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Dwdm\Users\Model\Entity\UserAttribute[] patchEntities($entities, array $data, array $options = [])
 * @method \Dwdm\Users\Model\Entity\UserAttribute findOrCreate($search, callable $callback = null, $options = [])
 */
class UserAttributesTable extends Table
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

        $this->setTable('user_attributes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

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
            ->requirePresence('value', 'create')
            ->notEmpty('value');

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
