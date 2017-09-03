<?php
use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('users', ['comment' => 'User primary properties']);

        $table
            ->addColumn('password', 'string',
                ['comment' => 'User password for user logging in by login/password', 'null' => true])
            ->addColumn('registered', 'datetime',
                ['comment' => 'User record creation time', 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('token', 'string',
                ['comment' => 'Token for restore user password', 'null' => true])
            ->addColumn('expiration', 'datetime',
                ['comment' => 'Restore password token expiration time', 'null' => true])
            ->addColumn('is_active', 'boolean',
                ['comment' => 'User not active, active or banned', 'null' => true]);

        $table->create();
    }
}
