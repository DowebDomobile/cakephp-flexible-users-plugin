<?php
namespace Dwdm\Users\Test\TestCase\Controller\Users;

use Dwdm\Users\Model\Entity\User;
use Dwdm\Users\Test\Fixture\UsersFixture;
use Dwdm\Users\Test\TestCase\Controller\UsersControllerTestCase;
use Cake\ORM\TableRegistry;

/**
 * Dwdm\Users\Controller\UsersController::add Test Case
 */
class RegisterActionTest extends UsersControllerTestCase
{
    public function testGetRegisterForm()
    {
        $this->get('/users/users/register');

        $this->assertEventFired('Controller.Users.register.before');
        $this->assertEventFired('Controller.Users.register.after');

        $this->assertResponseContains('Register');
        $this->assertResponseContains('Email');
        $this->assertResponseContains('name="email"');
        $this->assertResponseContains('Password');
        $this->assertResponseContains('name="password"');
        $this->assertResponseContains('Verify');
        $this->assertResponseContains('name="verify"');
        $this->assertResponseContains('Submit');

        $this->assertResponseOk();
    }

    public function testPostRegisterFormSuccess()
    {
        $this->post('/users/users/register',
            $data = ['email' => 'register@example.com', 'password' => 'password', 'verify' => 'password']);

        $this->assertEventFired('Controller.Users.register.before');
        $this->assertEventFired('Controller.Users.register.beforeSave');
        $this->assertEventFired('Controller.Users.register.afterSave');

        $this->assertResponseCode(302);

        /** @var UsersFixture $userFixture */
        $userFixture = $this->fixtureManager->loaded()['plugin.dwdm/users.users'];

        $query = TableRegistry::get('Dwdm/Users.Users')->find();

        $this->assertCount(count($userFixture->records) + 1, $query);

        $query = TableRegistry::get('Dwdm/Users.Users')
            ->find()
            ->contain(['UserContacts', 'UserAttributes'])
            ->where(['id <' => 100]);

        $this->assertCount(1, $query);

        /** @var User $user */
        $user = $query->first();

        $this->assertInstanceOf(User::class, $user);
        $this->assertNotEmpty($user->password);
        $this->assertNotEquals('password', $user->password);
        $this->assertNotEmpty($user->registered);
        $this->assertNull($user->token);
        $this->assertNull($user->expiration);
        $this->assertNull($user->is_active);

        $this->assertTrue($user->has('contacts'));
        $this->assertTrue($user->has('attributes'));

        $this->assertCount(1, $user->contacts);

        $contact = $user->contacts[0];
        $this->assertNull($contact->value);
        $this->assertEquals('email', $contact->name);
        $this->assertEquals('register@example.com', $contact->replace);
        $this->assertTrue($contact->is_login);
        $this->assertNotEmpty($contact->created);
        $this->assertNotEmpty($contact->updated);
        $this->assertNotEmpty($contact->token);
        $this->assertNull($contact->expiration);
    }

    public function testPostRegisterEmptyFromFail()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}