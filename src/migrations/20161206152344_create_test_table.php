<?php
/**
 * @copyright Bluz PHP Team
 * @link https://github.com/bluzphp/skeleton
 */

use Phinx\Migration\AbstractMigration;

/**
 * CreateTestTable
 */
class CreateTestTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->execute('REPLACE INTO `acl_privileges` (`roleId`, `module`, `privilege`) VALUES (\'2\',\'test\',\'Create\'),(\'2\',\'test\',\'Delete\'),(\'2\',\'test\',\'Read\'),(\'2\',\'test\',\'Update\');');
        $this->execute('CREATE TABLE `test` (`id` bigint(20) NOT NULL AUTO_INCREMENT, `name` varchar(255) DEFAULT NULL, `email` varchar(512) DEFAULT NULL, `status` enum(\'active\',\'disable\',\'delete\') DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;');
        $this->execute('REPLACE INTO `test`(`id`,`name`,`email`,`status`) VALUES (10,\'Jonah\',\'dictum@pharetra . ca\',\'disable\'),(11,\'Connor\',\'congue . In . scelerisque@Integervulputaterisus . ca\',\'disable\');');
    }
    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('test');
        $this->execute('DELETE FROM `auth` WHERE foreignKey=\'test\'');
        $this->execute('DELETE FROM `acl_privileges` WHERE module=\'test\'');
    }
}
