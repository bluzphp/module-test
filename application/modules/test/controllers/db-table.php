<?php
/**
 * Example of DB\Table usage
 *
 * @category Example
 *
 * @author   Anton Shevchuk
 * @created  18.07.13 13:35
 */

namespace Application;

use Bluz\Controller\Controller;
use Bluz\Proxy\Layout;

/**
 * @TODO: need more informative example
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
            'Table',
        ]
    );
    // all examples inside view
};
