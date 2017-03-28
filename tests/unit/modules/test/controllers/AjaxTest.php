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

/**
 * @group    module-test
 *
 * @package  Application\Tests\Test
 * @author   Anton Shevchuk
 * @created  19.05.14 12:33
 */
class AjaxTest extends ControllerTestCase
{
    /**
     * Dispatch module/controller
     */
    public function testAjax()
    {
        $this->dispatch('/test/ajax/', [], RequestMethod::POST, true);
        self::assertOk();
        self::assertNoticeMessage();
        self::assertResponseVariable('foo', 'bar');
    }

    /**
     * Dispatch module/controller
     */
    public function testAjaxWithParams()
    {
        $this->dispatch('/test/ajax/', ['messages'=>1], RequestMethod::POST, true);
        self::assertOk();
        self::assertErrorMessage();
        self::assertNoticeMessage();
        self::assertSuccessMessage();
        self::assertResponseVariable('foo', 'bar');
        self::assertResponseVariable('baz', 'qux');
    }
}
