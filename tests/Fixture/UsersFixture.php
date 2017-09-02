<?php
namespace Dwdm\Users\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 *
 */
class UsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'password' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => 'User password for user logging in by login/password', 'precision' => null, 'fixed' => null],
        'registered' => ['type' => 'timestamp', 'length' => null, 'default' => 'now()', 'null' => false, 'comment' => 'User record creation time', 'precision' => null],
        'token' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => 'Token for restore user password and confirm registration', 'precision' => null, 'fixed' => null],
        'expiration' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => 'Restore password token expiration time', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
            'password' => 'Lorem ipsum dolor sit amet',
            'registered' => 1504352970,
            'token' => 'Lorem ipsum dolor sit amet',
            'expiration' => 1504352970
        ],
    ];
}
