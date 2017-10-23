<?php
/**
 * Test of test of test
 *
 * @category Example
 *
 * @author   Anton Shevchuk
 * @created  21.08.12 12:39
 */

namespace Application;

use Bluz\Controller\Controller;
use Bluz\Proxy\Layout;

/**
 * @return void
 */
return function () {
    /**
     * @var Controller $this
     */
    Layout::title('Test Module');
    Layout::titleAppend('Append');
    Layout::titlePrepend('Prepend');
    Layout::breadCrumbs(['Test']);
};
