<?php

/**
 * Test of file download
 *
 * @category Example
 *
 * @author   Anton Shevchuk
 * @created  29.01.15 15:23
 */

namespace Application;

use Bluz\Controller\Controller;
use Bluz\Proxy\Response;

/**
 * @return void
 */
return function () {
    /**
     * @var Controller $this
     */
    Response::addHeader('Content-Description', 'File Transfer');
    Response::addHeader('Expires', '0');
    Response::addHeader('Cache-Control', 'must-revalidate');
    Response::addHeader('Pragma', 'public');

    $this->attachment(PATH_PUBLIC . '/img/loading.gif');
};
