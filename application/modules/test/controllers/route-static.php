<?php
/**
 * Example of static route
 *
 * @category Example
 *
 * @author   Anton Shevchuk
 * @created  12.06.12 13:08
 */
namespace Application;

use Bluz\Controller\Controller;
use Bluz\Proxy\Layout;
use Bluz\Proxy\Request;

/**
 * @route /static-route/
 * @route /another-route.html
 * @return string
 */
return function () {
    /**
     * @var Controller $this
     */
    Layout::breadCrumbs(
        [
            Layout::ahref('Test', [ 'test', 'index' ]),
            'Routers Examples',
        ]
    );

    $uri = Request::getUri();
    $module = Request::getModule();
    $controller = Request::getController();
    $content = <<<CODE
<p class="text-muted">$uri</p>
<div class="alert alert-light"><pre><code>/**
 * @route /static-route/
 * @route /another-route.html
 */</code></pre></div>
CODE;
    $this->assign('title', $module .'/'. $controller);
    $this->assign('content', $content);
    return 'modal.phtml';
};
