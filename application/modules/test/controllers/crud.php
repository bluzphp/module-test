<?php
/**
 * Example of Crud Controller
 *
 * @category Example
 *
 * @author   Anton Shevchuk
 * @created  04.09.12 11:21
 */
namespace Application;

use Application\Test;
use Bluz\Controller\Controller;
use Bluz\Controller\Mapper\Crud;

/**
 * @acl Read
 * @acl Create
 * @acl Update
 * @acl Delete
 *
 * @accept HTML
 * @accept JSON
 */
return function () {
    /**
     * @var Controller $this
     */
    $crud = new Crud(Test\Crud::getInstance());

    $crud
        ->get('system', 'crud/get')
        ->acl('Read')
    ;
    $crud
        ->post('system', 'crud/post')
        ->acl('Create')
    ;
    $crud
        ->put('system', 'crud/put')
        ->acl('Update')
    ;
    $crud
        ->delete('system', 'crud/delete')
        ->acl('Delete')
    ;

    return $crud->run();
};
