<?php
/**
 * @copyright Bluz PHP Team
 * @link https://github.com/bluzphp/skeleton
 */

use Phinx\Migration\AbstractMigration;

/**
 * CreateTestTable
 */
class TestPermissions extends AbstractMigration
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
