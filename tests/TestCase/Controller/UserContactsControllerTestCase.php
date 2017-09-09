<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller;

use Cake\Event\EventList;
use Cake\Event\EventManager;
use Cake\TestSuite\IntegrationTestCase;

class UserContactsControllerTestCase extends IntegrationTestCase
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
