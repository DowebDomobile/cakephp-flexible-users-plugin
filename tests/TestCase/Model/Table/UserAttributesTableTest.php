<?php
namespace Dwdm\Users\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Dwdm\Users\Model\Table\UserAttributesTable;

/**
 * Dwdm\Users\Model\Table\UserAttributesTable Test Case
 */
class UserAttributesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Dwdm\Users\Model\Table\UserAttributesTable
     */
    public $UserAttributes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('UserAttributes') ? [] : ['className' => UserAttributesTable::class];
        $this->UserAttributes = TableRegistry::get('UserAttributes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserAttributes);

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
}
