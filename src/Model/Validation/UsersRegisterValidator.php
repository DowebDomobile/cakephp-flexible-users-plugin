<?php
/** and confirm registration
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Model\Validation;

use Cake\Validation\Validator;

/**
 * Class UsersRegisterValidator
 * @package Dwdm\Users\Model\Validation
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