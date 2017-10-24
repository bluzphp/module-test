<?php
/**
 * Route with one param optional
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
 * @route /test/param/$
 * @route /test/param/{$a}/
 *
 * @param string $a
 *
 * @return string
 */
return function ($a = '42') {
    /**
     * @var Controller $this
     */
    Layout::breadCrumbs(
        [
            Layout::ahref('Test', ['test', 'index']),
            'Routers Examples',
        ]
    );

    $a = esc($a);

    $uri = Request::getUri();
    $module = Request::getModule();
    $controller = Request::getController();

    $content = <<<CODE
<p class="text-muted">$uri</p>
<div class="alert alert-light"><pre><code>/**
 * @route /test/param/
 * @route /test/param/{\$a}/
 * @param string \$a
 */
 return function (\$a = '42') {
     echo \$a; <em>// '$a'</em>
 }</code></pre></div>

CODE;
    $this->assign('title', $module . '/' . $controller);
    $this->assign('content', $content);
    return 'modal.phtml';
};
