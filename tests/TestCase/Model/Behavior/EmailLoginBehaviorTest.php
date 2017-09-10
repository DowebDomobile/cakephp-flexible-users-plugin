<?php
namespace Dwdm\Users\Test\TestCase\Model\Behavior;

use Cake\TestSuite\TestCase;
use Dwdm\Users\Model\Behavior\EmailLoginBehavior;
use Dwdm\Users\Model\Table\UsersTable;

/**
 * Dwdm\Users\Model\Behavior\EmailLoginBehavior Test Case
 */
class EmailLoginBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Dwdm\Users\Model\Behavior\EmailLoginBehavior
     */
    public $EmailLogin;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->EmailLogin = new EmailLoginBehavior(new UsersTable());
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailLogin);

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
