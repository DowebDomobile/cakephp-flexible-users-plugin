<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Validation;

use Dwdm\Users\Model\Table\UsersTable;

/**
 * Class PasswordConfirmValidator
 * @package Dwdm\Users\Validation
 */
class PasswordConfirmValidator extends PasswordVerifyValidator
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->requirePresence('token')
            ->scalar('token')
            ->add('token', 'exists', [
                'rule' => function ($value) {
                    /** @var UsersTable $Users */
                    $Users = $this->getProvider('table');
                    return $Users->exists(['token' => $value]);
                },
                'message' => __d('users', 'Invalid token')
            ]);
    }
}