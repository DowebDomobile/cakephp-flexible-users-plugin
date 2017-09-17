<?php
namespace Dwdm\Users\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use Dwdm\Users\Controller\Component\LoginComponent;

/**
 * Dwdm\Users\Controller\Component\LoginComponent Test Case
 */
class LoginComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Dwdm\Users\Controller\Component\LoginComponent
     */
    public $Login;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Login = new LoginComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Login);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
