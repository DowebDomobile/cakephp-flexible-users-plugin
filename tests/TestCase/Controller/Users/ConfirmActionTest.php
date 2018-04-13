<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Test\TestCase\Controller\Users;

use Cake\ORM\TableRegistry;
use Dwdm\Users\Model\Table\UsersTable;
use Dwdm\Users\Test\Fixture\UsersFixture;
use Dwdm\Users\Test\TestCase\Controller\UsersControllerTestCase;

/**
 * Class ConfirmActionTest
 * @package Dwdm\Users\Test\TestCase\Controller\Users
 */
class ConfirmActionTest extends UsersControllerTestCase
{
    public function testGetConfirmForm()
    {
        $this->get('/users/users/confirm/');

        $this->assertResponseContains('Enter new password');
        $this->assertResponseContains('<input type="password" name="password" required="required" id="password"/>');
        $this->assertResponseContains('<input type="password" name="verify" required="required" id="verify"/>');
        $this->assertResponseContains('<input type="text" name="token" required="required" maxlength="255" id="token"/>');

        $this->assertResponseOk();
    }

    public function testGetConfirmFormWithToken()
    {
        $this->get('/users/users/confirm/token');

        $this->assertResponseContains('Enter new password');
        $this->assertResponseContains('<input type="password" name="password" required="required" id="password"/>');
        $this->assertResponseContains('<input type="password" name="verify" required="required" id="verify"/>');
        $this->assertResponseContains('<input type="hidden" name="token" id="token" value="token"/>');

        $this->assertResponseOk();
    }

    public function testPostConfirmFormSuccess()
    {
        $this->post('/users/users/confirm/',
            ['password' => 'newPassword', 'verify' => 'newPassword', 'token' => 'token']);

        $this->assertResponseNotContains('<div class="error-message">');

        $this->assertRedirect('/users/users/login');
        $this->assertSession('Account updated successfully', 'Flash.flash.0.message');

        /** @var UsersTable $Users */
        $Users = TableRegistry::get('Users');

        $user = $Users->get(102);

        /** @var UsersFixture $userFixture */
        $userFixture = $this->fixtureManager->loaded()['plugin.dwdm/users.users'];

        $this->assertNotEquals($userFixture->records[2]['password'], $user->password);
        $this->assertNull($user->token);
    }

    public function testPostConfirmFormWithTokenSuccess()
    {
        $this->post('/users/users/confirm/token',
            ['password' => 'newPassword', 'verify' => 'newPassword', 'token' => 'token']);

        $this->assertResponseNotContains('<div class="error-message">');

        $this->assertRedirect('/users/users/login');
        $this->assertSession('Account updated successfully', 'Flash.flash.0.message');

        /** @var UsersTable $Users */
        $Users = TableRegistry::get('Users');

        $user = $Users->get(102);

        /** @var UsersFixture $userFixture */
        $userFixture = $this->fixtureManager->loaded()['plugin.dwdm/users.users'];

        $this->assertNotEquals($userFixture->records[2]['password'], $user->password);
        $this->assertNull($user->token);
    }

    public function testPostConfirmFormFails()
    {
        $this->post('/users/users/confirm/', ['password' => 'password', 'verify' => 'wrongPassword', 'token' => 'wrong']);

        $this->assertResponseContains('Enter new password');
        $this->assertResponseContains('<input type="password" name="password" required="required" id="password"/>');
        $this->assertResponseContains('<input type="password" name="verify" required="required" id="verify"/>');
        $this->assertResponseContains('<input type="text" name="token" required="required" maxlength="255" id="token" class="form-error" value="wrong"/>');

        $this->assertResponseOk();

        /** @var UsersTable $Users */
        $Users = TableRegistry::get('Users');

        $user = $Users->get(102);

        /** @var UsersFixture $userFixture */
        $userFixture = $this->fixtureManager->loaded()['plugin.dwdm/users.users'];

        $this->assertEquals($userFixture->records[2]['password'], $user->password);
        $this->assertEquals($userFixture->records[2]['token'], $user->token);
    }
}