<?php
namespace Dwdm\Users\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Query;
use Cake\ORM\Table;

/**
 * EmailLogin behavior
 */
class EmailLoginBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function findUser(Query $query, array $options)
    {
        $query->matching('UserContacts')
            ->where([
                'UserContacts.name' => 'email',
                'UserContacts.value' => $options['username'],
                'UserContacts.is_login' => true
            ], [], true);

        return $query;
    }
}
