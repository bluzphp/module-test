<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class TestPermissions extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $data = [
            [
                'roleId' => 2,
                'module' => 'test',
                'privilege' => 'Create'
            ],
            [
                'roleId' => 2,
                'module' => 'test',
                'privilege' => 'Read'
            ],
            [
                'roleId' => 2,
                'module' => 'test',
                'privilege' => 'Update'
            ],
            [
                'roleId' => 2,
                'module' => 'test',
                'privilege' => 'Delete'
            ],
        ];

        $privileges = $this->table('acl_privileges');
        $privileges->insert($data)
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM acl_privileges WHERE module = "test"');
    }
}
