<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Test\TestCase\Controller\Users;

use Dwdm\Users\Test\TestCase\Controller\UsersControllerTestCase;

/**
 * Class ConfirmActionTest
 * @package Dwdm\Users\Test\TestCase\Controller\Users
 */
class ConfirmActionTest extends UsersControllerTestCase
{
    public function testGetConfirmForm()
    {
        $this->markTestIncomplete('Confirm user will be soon');

        $this->get('/users/users/confirm/');

        $this->assertResponseOk();
    }
}