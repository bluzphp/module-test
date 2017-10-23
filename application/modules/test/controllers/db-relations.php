<?php
/**
 * Example of Db\Relations
 *
 * @category Example
 *
 * @author   Anton Shevchuk
 * @created  14.11.13 10:45
 */

namespace Application;

use Bluz\Controller\Controller;
use Bluz\Proxy\Db;
use Bluz\Proxy\Layout;

/**
 * @return bool
 */
return function () {
    /**
     * @var Controller $this
     */
    Layout::breadCrumbs(
        [
            Layout::ahref('Test', ['test', 'index']),
            'Database',
            'Relations',
        ]
    );
    // all examples inside view
};
