<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Validation;

use Cake\Validation\Validator;

/**
 * Class UsersRegisterValidator
 * @package Dwdm\Users\Validation
 */
class UsersRegisterValidator extends Validator
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->requirePresence('email')
            ->scalar('email')
            ->notEmpty('email')
            ->email('email');

        $this
            ->requirePresence('password')
            ->scalar('password')
            ->notEmpty('password')
            ->minLength('password', 6)
            ->add('password', 'compareWith', ['rule' => ['compareWith', 'verify']]);

        $this
            ->requirePresence('verify')
            ->scalar('verify')
            ->notEmpty('verify');
    }
}