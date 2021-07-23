<?php

/**
 * @copyright Bluz PHP Team
 * @link      https://github.com/bluzphp/skeleton
 */

declare(strict_types=1);

namespace Application\Test;

use Bluz\Grid\Grid;
use Bluz\Grid\Source\SqlSource;

/**
 * Test Grid based on SQL
 *
 * @category Application
 * @package  Test
 */
class SqlGrid extends Grid
{
    protected $uid = 'sql';

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        // Source of grid
        $adapter = new SqlSource();
        $adapter->setSource('SELECT * FROM test');

        $this->setAdapter($adapter);
        $this->setDefaultLimit(15);
        $this->setAllowOrders(['name', 'id', 'status']);
        $this->setAllowFilters(['status', 'id']);
        $this->setDefaultOrder('name', Grid::ORDER_DESC);
    }
}
