<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Validation;

use Cake\Validation\Validator;

/**
 * Class PasswordVerifyValidator
 * @package Dwdm\Users\Validation
 */
class PasswordVerifyValidator extends Validator
{
    public function __construct()
    {
        parent::__construct();

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