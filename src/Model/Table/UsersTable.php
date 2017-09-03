<?php
namespace Dwdm\Users\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Dwdm\Users\Model\Validation\UsersRegisterValidator;

/**
 * Users Model
 *
 * @property \Dwdm\Users\Model\Table\UserAttributesTable|\Cake\ORM\Association\HasMany $UserAttributes
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

        $this->setValidator('default', new UsersRegisterValidator());

        $this->hasMany('UserAttributes', [
            'foreignKey' => 'user_id',
            'className' => 'Dwdm/Users.UserAttributes',
            'propertyName' => 'attributes',
        ]);
        $this->hasMany('UserContacts', [
            'foreignKey' => 'user_id',
            'className' => 'Dwdm/Users.UserContacts',
            'propertyName' => 'contacts',
        ]);
    }
}
