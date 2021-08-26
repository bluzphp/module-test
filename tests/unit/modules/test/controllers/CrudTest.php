<?php

/**
 * @copyright Bluz PHP Team
 * @link https://github.com/bluzphp/skeleton
 */

/**
 * @namespace
 */
namespace Application\Tests\Test;

use Application\Tests\ControllerTestCase;
use Bluz\Http\RequestMethod;
use Bluz\Http\StatusCode;
use Bluz\Proxy\Db;
use Bluz\Proxy\Response;

/**
 * @group    module-test
 *
 * @package  Application\Tests\Test
 * @author   Anton Shevchuk
 * @created  21.05.14 11:28
 */
class CrudTest extends ControllerTestCase
{
    /**
     * Setup environment before run every test
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        self::setupSuperUserIdentity();
        self::getApp()->useLayout(false);

        Db::insert('test')->setArray(
            [
                'id' => 1001,
                'name' => 'Donatello',
                'email' => 'donatello@turtles.org'
            ]
        )->execute();

        Db::insert('test')->setArray(
            [
                'id' => 1002,
                'name' => 'Leonardo',
                'email' => 'leonardo@turtles.org'
            ]
        )->execute();

        Db::insert('test')->setArray(
            [
                'id' => 1003,
                'name' => 'Michelangelo',
                'email' => 'michelangelo@turtles.org'
            ]
        )->execute();

        Db::insert('test')->setArray(
            [
                'id' => 1004,
                'name' => 'Raphael',
                'email' => 'raphael@turtles.org'
            ]
        )->execute();
    }

    /**
     * Tear down environment
     */
    public function tearDown(): void
    {
        Db::delete('test')->where('id > ?', 1000)->execute();
        parent::tearDown();
    }

    /**
     * GET request should return FORM for create record
     */
    public function testCreateForm()
    {
        $this->dispatch('/test/crud/');
        self::assertOk();
        self::assertQueryCount('form[method="POST"]', 1);
    }

    /**
     * GET request with ID record should return FORM for edit
     */
    public function testEditForm()
    {
        $this->dispatch('/test/crud/', ['id' => 1001]);

        self::assertOk();
        self::assertQueryCount('form[method="PUT"]', 1);
        self::assertQueryCount('input[name="id"][value="1001"]', 1);
    }

    /**
     * GET request with wrong ID record should return ERROR 404
     */
    public function testEditFormError()
    {
        $this->dispatch('/test/crud/', ['id' => 100042]);

        self::assertResponseCode(StatusCode::NOT_FOUND);
    }

    /**
     * POST request should CREATE record
     */
    public function testCreate()
    {
        $this->dispatch(
            '/test/crud/',
            ['name' => 'Splinter', 'email' => 'splinter@turtles.org'],
            RequestMethod::POST
        );
        self::assertOk();

        $count = Db::fetchOne(
            'SELECT count(*) FROM `test` WHERE `name` = ?',
            ['Splinter']
        );
        self::assertEquals($count, 1);
    }

    /**
     * POST request with empty data should return ERROR and information
     */
    public function testCreateValidationErrors()
    {
        $this->dispatch(
            '/test/crud/',
            ['name' => '', 'email' => ''],
            RequestMethod::POST
        );

        self::assertNotNull(Response::getBody()->getData()->get('errors'));
        self::assertCount(2, Response::getBody()->getData()->get('errors'));
        self::assertOk();
    }

    /**
     * PUT request CRUD controller should UPDATE record
     */
    public function testUpdate()
    {
        $this->dispatch(
            '/test/crud/',
            ['id' => 1002, 'name' => 'Leonardo', 'email' => 'leonardo@turtles.ua'],
            RequestMethod::PUT
        );
        ;
        self::assertOk();

        $id = Db::fetchOne(
            'SELECT `id` FROM `test` WHERE `email` = ?',
            ['leonardo@turtles.ua']
        );
        self::assertEquals($id, 1002);
    }

    /**
     * PUT request with invalid data should return ERROR and information
     */
    public function testUpdateValidationErrors()
    {
        $this->dispatch(
            '/test/crud/',
            ['id' => 1002, 'name' => '123456', 'email' => 'leonardo[at]turtles.ua'],
            RequestMethod::PUT
        );
        ;
        self::assertNotNull(Response::getBody()->getData()->get('errors'));
        self::assertCount(2, Response::getBody()->getData()->get('errors'));
        self::assertOk();
    }

    /**
     * DELETE request should remove record
     */
    public function testDelete()
    {
        $this->dispatch(
            '/test/crud/',
            ['id' => 1003],
            RequestMethod::DELETE
        );
        self::assertOk();

        $count = Db::fetchOne(
            'SELECT count(*) FROM `test` WHERE `email` = ?',
            ['michelangelo@turtles.org']
        );
        self::assertEquals($count, 0);
    }

    /**
     * DELETE request with invalid id should return ERROR
     */
    public function testDeleteError()
    {
        $this->dispatch(
            '/test/crud/',
            ['id' => 100042],
            RequestMethod::DELETE
        );

        self::assertResponseCode(StatusCode::NOT_FOUND);
    }
}
