<?php
namespace Dwdm\Users\Test\TestCase\Controller;

use Cake\Event\EventList;
use Cake\Event\EventManager;
use Cake\TestSuite\IntegrationTestCase;

/**
 * Dwdm\Users\Controller\UsersController Test Case
 */
class UsersControllerTestCase extends IntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.dwdm/users.users',
        'plugin.dwdm/users.user_contacts',
        'plugin.dwdm/users.user_attributes',
    ];

    public function setUp()
    {
        parent::setUp();

        EventManager::instance()->setEventList(new EventList());
    }
}
