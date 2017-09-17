<?php
namespace Dwdm\Users\Test\TestCase\Model\Behavior;

use Cake\TestSuite\TestCase;
use Dwdm\Users\Model\Behavior\LoginBehavior;
use Dwdm\Users\Model\Table\UsersTable;

/**
 * Dwdm\Users\Model\Behavior\LoginBehavior Test Case
 */
class LoginBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Dwdm\Users\Model\Behavior\LoginBehavior
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
        $this->Login = new LoginBehavior(new UsersTable());
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
