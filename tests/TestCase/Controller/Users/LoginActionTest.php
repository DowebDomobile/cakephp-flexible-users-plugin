<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Test\TestCase\Controller\Users;

use Dwdm\Users\Test\TestCase\Controller\UsersControllerTestCase;

class LoginActionTest extends UsersControllerTestCase
{
    public function testGet()
    {
        $this->get('/users/users/login');

        $this->assertResponseContains('<legend>Login</legend>');
        $this->assertResponseContains('Email');
        $this->assertResponseContains('name="email"');
        $this->assertResponseContains('Password');
        $this->assertResponseContains('name="password"');
        $this->assertResponseContains('<button type="submit">Login</button>');

        $this->assertResponseOk();

        $this->assertEventFired('Controller.Users.login.before');
        $this->assertEventFired('Controller.Users.login.after');
    }

    public function testPostSuccess()
    {
        $this->post('/users/users/login', ['email' => 'user100@example.com', 'password' => 'password']);

        $this->assertResponseNotContains('Username or password is incorrect');

        $this->assertResponseCode(302);

        $this->assertEventFired('Controller.Users.login.before');
        $this->assertEventFired('Controller.Users.login.afterIdentify');
    }

    public function testPostFail()
    {
        $this->post('/users/users/login', ['email' => 'user100@example.com', 'password' => 'invalid']);

        $this->assertResponseContains('Username or password is incorrect');
        $this->assertResponseContains('<legend>Login</legend>');
        $this->assertResponseContains('Email');
        $this->assertResponseContains('name="email"');
        $this->assertResponseContains('Password');
        $this->assertResponseContains('name="password"');
        $this->assertResponseContains('<button type="submit">Login</button>');

        $this->assertResponseOk();

        $this->assertEventFired('Controller.Users.login.before');
        $this->assertEventFired('Controller.Users.login.afterFail');
        $this->assertEventFired('Controller.Users.login.after');
    }
}
