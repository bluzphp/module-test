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
class RestTest extends ControllerTestCase
{
    /**
     * Setup `test` table before the first test
     */
    public static function setUpBeforeClass()
    {
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
     * Drop `test` table after the last test
     */
    public static function tearDownAfterClass()
    {
        Db::delete('test')->where('id IN (?)', [1001,1002,1003,1004])->execute();
        Db::delete('test')->where('email = ?', 'splinter@turtles.org')->execute();
    }

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        self::setupSuperUserIdentity();
        $this->getApp()->useLayout(false);
        Response::setHeader('Content-Type', 'application/json');
    }

    /**
     * GET request with PRIMARY should return one record
     */
    public function testReadOne()
    {
        $this->dispatch('/test/rest/1001');

        self::assertOk();

        /** @var \Application\Test\Row $row */
        $row = current(Response::getBody()->getData()->toArray());


        self::assertEquals($row->id, 1001);
    }

    /**
     * GET request should return SET of records
     */
    public function testReadSet()
    {
        $this->dispatch('/test/rest/', ['offset' => 0, 'limit' => 3]);

        self::assertResponseCode(StatusCode::PARTIAL_CONTENT);
        self::assertEquals(sizeof(Response::getBody()->getData()->toArray()), 3);
        self::assertEquals(Response::getHeader('Content-Range'), 'items 0-3/104');
    }

    /**
     * POST request with params should CREATE row and return PRIMARY
     */
    public function testCreate()
    {
        $this->dispatch(
            '/test/rest/',
            ['name' => 'Splinter', 'email' => 'splinter@turtles.org'],
            RequestMethod::POST
        );

        $primary = Db::fetchOne(
            'SELECT id FROM `test` WHERE `name` = ?',
            ['Splinter']
        );

        self::assertResponseCode(StatusCode::CREATED);
        self::assertEquals(Response::getHeader('Location'), '/test/rest/'.$primary);
    }

    /**
     * POST request with PRIMARY should return ERROR
     */
    public function testCreateWithPrimaryError()
    {
        $this->dispatch('/test/rest/1001', [], RequestMethod::POST);
        self::assertResponseCode(StatusCode::NOT_IMPLEMENTED);
    }

    /**
     * POST request without DATA should return ERROR
     */
    public function testCreateWithoutDataError()
    {
        $this->dispatch('/test/rest/', [], RequestMethod::POST);
        self::assertResponseCode(StatusCode::BAD_REQUEST);
    }

    /**
     * POST request with invalid data should return ERROR and information
     */
    public function testCreateValidationErrors()
    {
        $this->dispatch(
            '/test/rest/',
            ['name' => '', 'email' => ''],
            RequestMethod::POST
        );

        self::assertNotNull(Response::getBody()->getData()->get('errors'));
        self::assertEquals(sizeof(Response::getBody()->getData()->get('errors')), 2);
        self::assertResponseCode(StatusCode::BAD_REQUEST);
    }

    /**
     * PUT request with PRIMARY should UPDATE record
     */
    public function testUpdate()
    {
        $this->dispatch(
            '/test/rest/1002',
            ['name' => 'Leonardo', 'email' => 'leonardo@turtles.ua'],
            RequestMethod::PUT
        );
        ;
        self::assertOk();

        $id = Db::fetchOne(
            'SELECT `id` FROM `test` WHERE `email` = ?',
            ['leonardo@turtles.ua']
        );
        self::assertEquals($id, 2);
    }

    /**
     * PUT request with SET of DATA should UPDATE SET
     * @todo update set is not implemented in Crud\Table package
     */
    public function testUpdateSet()
    {
        $this->dispatch(
            '/test/rest/',
            [
                ['id' => 1003, 'name' => 'Michelangelo', 'email' => 'michelangelo@turtles.org.ua'],
                ['id' => 1004, 'name' => 'Raphael', 'email' => 'Raphael@turtles.org.ua'],
            ],
            RequestMethod::PUT
        );

        self::assertResponseCode(StatusCode::NOT_IMPLEMENTED);

        /*
        self::assertOk();

        $count = Db::fetchOne(
            'SELECT count(*) FROM `test` WHERE `email` LIKE(?)',
            ['%turtles.org.ua']
        );
        self::assertEquals($count, 2);
        */
    }

    /**
     * PUT request with same PRIMARY should return code 304
     */
    public function testUpdateWithSameData()
    {
        $this->dispatch('/test/rest/1001', ['name' => 'Donatello'], RequestMethod::PUT);
        self::assertResponseCode(StatusCode::NOT_MODIFIED);
    }

    /**
     * PUT request with invalid PRIMARY should return ERROR
     */
    public function testUpdateWithInvalidPrimary()
    {
        $this->dispatch('/test/rest/100042', ['name' => 'Raphael'], RequestMethod::PUT);
        self::assertResponseCode(StatusCode::NOT_FOUND);
    }

    /**
     * PUT request without DATA should return ERROR
     */
    public function testUpdateWithoutDataError()
    {
        $this->dispatch('/test/rest/', [], RequestMethod::PUT);
        self::assertResponseCode(StatusCode::BAD_REQUEST);
    }

    /**
     * DELETE request with PRIMARY
     */
    public function testDelete()
    {
        $this->dispatch('/test/rest/1001', [], RequestMethod::DELETE);
        self::assertResponseCode(StatusCode::NO_CONTENT);

        $count = Db::fetchOne(
            'SELECT count(*) FROM `test` WHERE `id` = ?',
            [1]
        );
        self::assertEquals($count, 0);
    }

    /**
     * DELETE request with invalid PRIMARY should return ERROR
     */
    public function testDeleteWithInvalidPrimary()
    {
        $this->dispatch('/test/rest/100042', [], RequestMethod::DELETE);
        self::assertResponseCode(StatusCode::NOT_FOUND);
    }

    /**
     * DELETE request with SET of DATA should DELETE SET
     * @todo update set is not implemented in Crud\Table package
     */
    public function testDeleteSet()
    {
        $this->dispatch(
            '/test/rest/',
            [
                ['id' => 1003],
                ['id' => 1004],
            ],
            RequestMethod::DELETE
        );

        self::assertResponseCode(StatusCode::NOT_IMPLEMENTED);

        /*
        self::assertOk();

        $count = Db::fetchOne(
            'SELECT count(*) FROM `test` WHERE `id` IN (3,4)'
        );
        self::assertEquals($count, 0);
        */
    }
}
