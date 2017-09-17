<?php
namespace Dwdm\Users\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use Dwdm\Users\Controller\Component\RegisterComponent;

/**
 * Dwdm\Users\Controller\Component\RegisterComponent Test Case
 */
class RegisterComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Dwdm\Users\Controller\Component\RegisterComponent
     */
    public $Register;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Register = new RegisterComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Register);

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
