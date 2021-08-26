<?php

/**
 * Complex example of REST controller
 *
 * @category Example
 *
 * @author   Anton Shevchuk
 * @created  19.02.15 16:27
 */

namespace Application;

use Application\Test;
use Bluz\Http\Exception\ForbiddenException;
use Bluz\Controller\Controller;
use Bluz\Controller\Mapper\Rest;

/**
 * @accept HTML
 * @accept JSON
 * @acl    Read
 * @acl    Create
 * @acl    Update
 * @acl    Delete
 *
 * @return mixed
 */
return function () {
    /**
     * @var Controller $this
     */
    $rest = new Rest(Test\Crud::getInstance());

    $rest
        ->head('system', 'rest/head')
        ->acl('Read');
    $rest
        ->get('system', 'rest/get')
        ->acl('Read');
    $rest
        ->options('system', 'rest/options')
        ->acl('Read');
    $rest
        ->post('system', 'rest/post')
        ->acl('Create');
    $rest
        ->put('system', 'rest/put')
        ->acl('Update');
    $rest
        ->patch('system', 'rest/put')
        ->acl('Update');
    $rest
        ->delete('system', 'rest/delete')
        ->acl('Delete');

    return $rest->run();
};
