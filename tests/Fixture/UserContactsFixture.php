<?php
namespace Dwdm\Users\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserContactsFixture
 *
 */
class UserContactsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'user_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => 'Link to id column in users table', 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 30, 'default' => null, 'null' => false, 'collate' => null, 'comment' => 'Contact handler name', 'precision' => null, 'fixed' => null],
        'value' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => 'Contact value', 'precision' => null, 'fixed' => null],
        'is_login' => ['type' => 'boolean', 'length' => null, 'default' => null, 'null' => false, 'comment' => 'Mark contact as login name', 'precision' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => 'now()', 'null' => false, 'comment' => 'Contact creation date', 'precision' => null],
        'updated' => ['type' => 'timestamp', 'length' => null, 'default' => 'now()', 'null' => false, 'comment' => 'Contact renew date', 'precision' => null],
        'replace' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => 'Contact value for replace after confirmation', 'precision' => null, 'fixed' => null],
        'token' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => 'Token for confirm new contact value', 'precision' => null, 'fixed' => null],
        'expiration' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => 'Expiration date for confirmation token', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'user_contacts_user_id' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'user_id' => 1,
            'name' => 'Lorem ipsum dolor sit amet',
            'value' => 'Lorem ipsum dolor sit amet',
            'is_login' => 1,
            'created' => 1504352977,
            'updated' => 1504352977,
            'replace' => 'Lorem ipsum dolor sit amet',
            'token' => 'Lorem ipsum dolor sit amet',
            'expiration' => 1504352977
        ],
    ];
}
