<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Test\TestCase\Controller\Users;

use Cake\ORM\TableRegistry;
use Dwdm\Users\Model\Entity\User;
use Dwdm\Users\Test\Fixture\UserContactsFixture;
use Dwdm\Users\Test\Fixture\UsersFixture;
use Dwdm\Users\Test\TestCase\Controller\UsersControllerTestCase;

/**
 * Class RestoreActionTest
 * @package Dwdm\Users\Test\TestCase\Controller\Users
 */
class RestoreActionTest extends UsersControllerTestCase
{
    public function testGetRestoreForm()
    {
        $this->get('/users/users/restore');

        $this->assertResponseContains('Restore password');
        $this->assertResponseContains('email');
        $this->assertResponseContains('name="email"');
        $this->assertResponseContains('<button type="submit">Restore</button>');
        $this->assertResponseOk();
    }

    public function testPostRestoreFormSuccess()
    {
        /** @var UsersFixture $userFixture */
        $userFixture = $this->fixtureManager->loaded()['plugin.dwdm/users.users'];
        $user = $userFixture->records[0];

        /** @var UserContactsFixture $contactFixture */
        $contactFixture = $this->fixtureManager->loaded()['plugin.dwdm/users.user_contacts'];
        $contact = $contactFixture->records[0];

        $this->post('/users/users/restore', ['email' => $contact['value']]);

        $this->assertResponseCode(302);

        $query = TableRegistry::get('Dwdm/Users.Users')->find();

        $this->assertCount(count($userFixture->records), $query);

        /** @var User $actualUser */
        $actualUser = $query->where(['Users.id' => $user['id']])->first();

        $this->assertInstanceOf(User::class, $actualUser);
        $this->assertNotNull($actualUser->token);
        $this->assertEquals($user['password'], $actualUser->password);
    }

    public function testPostRestoreFormFail()
    {
        $this->post('/users/users/restore', ['email' => 'invalid']);

        $this->assertResponseContains('User not found.');
        $this->assertResponseContains('Restore password');
        $this->assertResponseContains('email');
        $this->assertResponseContains('name="email"');
        $this->assertResponseContains('<button type="submit">Restore</button>');
        $this->assertResponseOk();
    }
}