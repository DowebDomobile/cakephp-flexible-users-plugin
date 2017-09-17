<?php
namespace Dwdm\Users\Test\TestCase\Controller\Component;

use Cake\Controller\Component\AuthComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Event\EventManager;
use Cake\TestSuite\TestCase;
use Dwdm\Users\Controller\Component\PasswordComponent;

/**
 * Dwdm\Users\Controller\Component\PasswordComponent Test Case
 */
class PasswordComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Dwdm\Users\Controller\Component\PasswordComponent
     */
    public $Password;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $registry = new ComponentRegistry();
        $mockEventManager = $this->createMock(EventManager::class);
        $mockAuth = $this->createMock(AuthComponent::class);
        $mockAuth->method('allow')->with($this->isType('array'));
        $mockController = $this->createMock(Controller::class);
        $mockController->method('getEventManager')->will($this->returnValue($mockEventManager));
        $mockController->method('components')->will($this->returnValue($registry));

        /** @var Controller $mockController */
        $registry->setController($mockController);
        $this->Password = new PasswordComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Password);

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
