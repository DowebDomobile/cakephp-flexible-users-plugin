<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Query;

/**
 * Login behavior
 */
class LoginBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'contact' => ['names' => 'email']
    ];

    public function findUser(Query $query, array $options)
    {
        $query->matching('UserContacts')
            ->where([
                'UserContacts.name IN' => $this->getConfig('contact.names'),
                'UserContacts.value' => $options['username'],
                'UserContacts.is_login' => true
            ], [], true);

        return $query;
    }
}
