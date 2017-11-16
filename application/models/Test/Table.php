<?php
/**
 * @copyright Bluz PHP Team
 * @link      https://github.com/bluzphp/skeleton
 */

declare(strict_types=1);

namespace Application\Test;

/**
 * Table
 *
 * @package  Application\Test
 *
 * @method   static Row findRow($primaryKey)
 * @method   static Row findRowWhere($whereList)
 *
 * @author   Anton Shevchuk
 * @created  08.07.11 17:36
 */
class Table extends \Bluz\Db\Table
{
    /**
     * Table
     *
     * @var string
     */
    protected $name = 'test';

    /**
     * Primary key(s)
     *
     * @var array
     */
    protected $primary = ['id'];

    /**
     * save test row
     *
     * @return null|string
     */
    public function saveTestRow()
    {
        return self::insert(['name' => 'Example #' . random_int(1, 10), 'email' => 'example@example.com']);
    }

    /**
     * update test row
     *
     * @return integer
     */
    public function updateTestRows()
    {
        return self::update(['email' => 'example2@example.com'], ['email' => 'example@example.com']);
    }

    /**
     * delete test row
     *
     * @return integer
     */
    public function deleteTestRows()
    {
        return self::delete(['email' => 'example2@example.com']);
    }
}
