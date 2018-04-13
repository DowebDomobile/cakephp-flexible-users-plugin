<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Validation;

/**
 * Class UsersRegisterValidator
 * @package Dwdm\Users\Validation
 */
class UsersRegisterValidator extends PasswordVerifyValidator
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->requirePresence('email')
            ->scalar('email')
            ->notEmpty('email')
            ->email('email');
    }
}