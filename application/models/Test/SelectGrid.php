<?php
/**
 * @copyright Bluz PHP Team
 * @link      https://github.com/bluzphp/skeleton
 */

declare(strict_types=1);

namespace Application\Test;

use Bluz\Db\Query\Select;
use Bluz\Grid\Grid;
use Bluz\Grid\Source\SelectSource;

/**
 * Test Grid based on SQL
 *
 * @category Application
 * @package  Test
 */
class SelectGrid extends Grid
{
    protected $uid = 'sel';

    /**
     * init
     *
     * @return self
     */
    public function init()
    {
        // Source of grid
        $adapter = new SelectSource();

        $select = new Select();
        $select->select('*')->from('test', 't');

        $adapter->setSource($select);

        $this->setAdapter($adapter);
        $this->setDefaultLimit(15);
        $this->setAllowOrders(['name', 'id', 'status']);
        $this->setAllowFilters(['status', 'id']);

        return $this;
    }
}
