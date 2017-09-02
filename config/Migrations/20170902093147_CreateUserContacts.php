<?php
use Migrations\AbstractMigration;
use Phinx\Db\Table\ForeignKey;

class CreateUserContacts extends AbstractMigration
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
        $table = $this->table('user_contacts', ['comment' => 'User contacts for logging in and notifications.']);

        $table
            ->addColumn('user_id', 'integer', ['comment' => 'Link to id column in users table'])
            ->addColumn('name', 'string', ['length' => 30, 'comment' => 'Contact handler name'])
            ->addColumn('value', 'string', ['comment' => 'Contact value'])
            ->addColumn('is_login', 'boolean', ['comment' => 'Mark contact as login name'])
            ->addColumn('created', 'datetime',
                ['comment' => 'Contact creation date', 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated', 'datetime',
                ['comment' => 'Contact renew date', 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('replace', 'string',
                ['comment' => 'Contact value for replace after confirmation', 'null' => true])
            ->addColumn('token', 'string', ['comment' => 'Token for confirm new contact value', 'null' => true])
            ->addColumn('expiration', 'datetime',
                ['comment' => 'Expiration date for confirmation token', 'null' => true]);

        $table->addForeignKey('user_id', 'users', 'id',
            ['update' => ForeignKey::CASCADE, 'delete' => ForeignKey::CASCADE]);

        $table->create();
    }
}
