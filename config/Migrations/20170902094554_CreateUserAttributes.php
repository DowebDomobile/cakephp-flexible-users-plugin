<?php
use Migrations\AbstractMigration;
use Phinx\Db\Table\ForeignKey;

class CreateUserAttributes extends AbstractMigration
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
        $table = $this->table('user_attributes');

        $table
            ->addColumn('user_id', 'integer', ['comment' => 'Link to id column in users table'])
            ->addColumn('name', 'string', ['comment' => 'Attribute handler name'])
            ->addColumn('value', 'string', ['comment' => 'Attribute value']);

        $table->addForeignKey('user_id', 'users', 'id',
            ['update' => ForeignKey::CASCADE, 'delete' => ForeignKey::CASCADE]);

        $table->create();
    }
}
