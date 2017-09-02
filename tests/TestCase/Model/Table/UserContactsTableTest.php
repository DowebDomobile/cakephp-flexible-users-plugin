<?php
namespace Dwdm\Users\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Dwdm\Users\Model\Table\UserContactsTable;

/**
 * Dwdm\Users\Model\Table\UserContactsTable Test Case
 */
class UserContactsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Dwdm\Users\Model\Table\UserContactsTable
     */
    public $UserContacts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.dwdm/users.user_contacts',
        'plugin.dwdm/users.users',
        'plugin.dwdm/users.user_attributes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserContacts') ? [] : ['className' => UserContactsTable::class];
        $this->UserContacts = TableRegistry::get('UserContacts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserContacts);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
