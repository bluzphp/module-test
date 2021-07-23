<?php

/**
 * Example of route with many params
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
 * @route /{$a}-{$b}-{$c}/
 *
 * @param int    $a
 * @param float  $b
 * @param string $c
 *
 * @return string
 */
return function ($a, $b, $c) {
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
    $b = esc($b);
    $c = esc($c);
    $uri = Request::getUri();
    $module = Request::getModule();
    $controller = Request::getController();

    $content = <<<CODE
<p class="text-muted">$uri</p>
<div class="alert alert-light"><pre><code>/**
 * @route /{\$a}-{\$b}-{\$c}/
 * @param int \$a
 * @param float \$b
 * @param string \$c
 */
 return function (\$a, \$b, \$c) {
     echo \$a; <em>// '$a'</em>
     echo \$b; <em>// '$b'</em>
     echo \$c; <em>// '$c'</em>
 }</code></pre></div>
CODE;
    $this->assign('title', $module . '/' . $controller);
    $this->assign('content', $content);
    return 'modal.phtml';
};
