<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Test\TestCase\Controller\UserContacts;

use Cake\ORM\TableRegistry;
use Dwdm\Users\Model\Entity\User;
use Dwdm\Users\Model\Entity\UserContact;
use Dwdm\Users\Test\Fixture\UserContactsFixture;
use Dwdm\Users\Test\TestCase\Controller\UsersControllerTestCase;

/**
 * Class ConfirmActionTest
 * @package Dwdm\Users\Test\TestCase\Controller\UserContacts
 */
class ConfirmActionTest extends UsersControllerTestCase
{
    public function testGetForm()
    {
        $this->get('/users/user-contacts/confirm/100');

        $this->assertResponseContains('Confirm contact');
        $this->assertResponseContains('Contact');
        $this->assertResponseContains('name="replace"');
        $this->assertResponseContains('Token');
        $this->assertResponseContains('name="token"');
        $this->assertResponseContains('Submit');

        $this->assertResponseNotContains('Contact was not found');

        $this->assertResponseOk();
    }

    public function testGetWithConfirmToken()
    {
        /** @var UserContactsFixture $contactFixture */
        $contactFixture = $this->fixtureManager->loaded()['plugin.dwdm/users.user_contacts'];
        $contact = $contactFixture->records[1];

        $this->get(sprintf('/users/user-contacts/confirm/%d/%s', $contact['id'], $contact['token']));

        $this->assertResponseCode(302);

        $query = TableRegistry::get('Dwdm/Users.UserContacts')
            ->find()
            ->contain(['Users'])
            ->where(['UserContacts.id' => $contact['id']]);

        $this->assertCount(1, $query);

        /** @var UserContact $actualContact */
        $actualContact = $query->first();

        $this->assertInstanceOf(UserContact::class, $actualContact);
        $this->assertEquals($contact['replace'], $actualContact->value);
        $this->assertNull($actualContact->replace);
        $this->assertNull($actualContact->token);

        $this->assertTrue($actualContact->has('user'));

        $this->assertInstanceOf(User::class, $actualContact->user);
        $this->assertTrue($actualContact->user->is_active);
    }

    public function testPostAfterChange()
    {
        /** @var UserContactsFixture $contactFixture */
        $contactFixture = $this->fixtureManager->loaded()['plugin.dwdm/users.user_contacts'];
        $contact = $contactFixture->records[2];

        $this->post('/users/user-contacts/confirm/' . $contact['id'],
            ['replace' => $contact['replace'], 'token' => $contact['token']]);

        $this->assertResponseCode(302);

        $query = TableRegistry::get('Dwdm/Users.UserContacts')
            ->find()
            ->contain(['Users'])
            ->where(['UserContacts.id' => $contact['id']]);

        $this->assertCount(1, $query);

        /** @var UserContact $actualContact */
        $actualContact = $query->first();

        $this->assertInstanceOf(UserContact::class, $actualContact);
        $this->assertEquals($contact['replace'], $actualContact->value);
        $this->assertNull($actualContact->replace);
        $this->assertNull($actualContact->token);

        $this->assertTrue($actualContact->has('user'));

        $this->assertInstanceOf(User::class, $actualContact->user);
        $this->assertTrue($actualContact->user->is_active);
    }

    public function testGetNotFound()
    {
        /** @var UserContactsFixture $contactFixture */
        $contactFixture = $this->fixtureManager->loaded()['plugin.dwdm/users.user_contacts'];
        $contact = $contactFixture->records[1];

        $this->get(sprintf('/users/user-contacts/confirm/%d/%s', $contact['id'], 'InvalidToken'));

        $this->assertResponseCode(404);

        $query = TableRegistry::get('Dwdm/Users.UserContacts')
            ->find()
            ->contain(['Users'])
            ->where(['UserContacts.id' => $contact['id']]);

        $this->assertCount(1, $query);

        /** @var UserContact $actualContact */
        $actualContact = $query->first();

        $this->assertInstanceOf(UserContact::class, $actualContact);
        $this->assertEquals($contact['replace'], $actualContact->replace);
        $this->assertEquals($contact['token'], $actualContact->token);
        $this->assertNull($actualContact->value);

        $this->assertTrue($actualContact->has('user'));

        $this->assertInstanceOf(User::class, $actualContact->user);
        $this->assertNull($actualContact->user->is_active);
    }

    public function testPostNotFound()
    {
        /** @var UserContactsFixture $contactFixture */
        $contactFixture = $this->fixtureManager->loaded()['plugin.dwdm/users.user_contacts'];
        $contact = $contactFixture->records[1];

        $this->post('/users/user-contacts/confirm', ['email' => $contact['replace'], 'token' => 'InvalidToken']);

        $this->assertResponseCode(404);

        $query = TableRegistry::get('Dwdm/Users.UserContacts')
            ->find()
            ->contain(['Users'])
            ->where(['UserContacts.id' => $contact['id']]);

        $this->assertCount(1, $query);

        /** @var UserContact $actualContact */
        $actualContact = $query->first();

        $this->assertInstanceOf(UserContact::class, $actualContact);
        $this->assertEquals($contact['replace'], $actualContact->replace);
        $this->assertEquals($contact['token'], $actualContact->token);
        $this->assertNull($actualContact->value);

        $this->assertTrue($actualContact->has('user'));

        $this->assertInstanceOf(User::class, $actualContact->user);
        $this->assertNull($actualContact->user->is_active);
    }
}