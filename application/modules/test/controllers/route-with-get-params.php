<?php
/**
 * Router with other params
 *
 * @category Example
 *
 * @author   Anton Shevchuk
 * @created  18.12.13 18:39
 */
namespace Application;

use Bluz\Controller\Controller;
use Bluz\Proxy\Request;

/**
 * @route /test/route-with-other-params/{$alias}(.*)
 * @param string $alias
 * @return string
 */
return function ($alias) {
    /**
     * @var Controller $this
     */
    $id = Request::getParam('id');
    $alias = esc($alias);
    $id = esc($id);

    $uri = Request::getUri();
    $module = Request::getModule();
    $controller = Request::getController();

    $content = <<<CODE
<p class="text-muted">$uri</p>
<div class="alert alert-light"><pre><code>/**
 * @route /test/route-with-get-params/{$alias}(.*)
 * @param string $alias
 */
 return function (\$alias) {
     echo \$alias; <em>// '$alias'</em>
     echo \$id;    <em>// '$id'</em>
 }</code></pre></div>
CODE;
    $this->assign('title', $module .'/'. $controller);
    $this->assign('content', $content);
    return 'modal.phtml';
};
