<?php
/**
 * @copyright Bluz PHP Team
 * @link      https://github.com/bluzphp/skeleton
 */

declare(strict_types=1);

namespace Application\Test;

use Bluz\Validator\Traits\Validator;

/**
 * Test Row
 *
 * @package  Application\Test
 *
 * @property integer $id
 * @property string  $name
 * @property string  $email
 * @property string  $status enum('active','disable','delete')
 *
 * @SWG\Definition(definition="test", title="test", required={"id", "name", "email"})
 * @SWG\Property(property="id", type="integer")
 * @SWG\Property(property="name", type="string")
 * @SWG\Property(property="email", type="string")
 * @SWG\Property(property="status", type="string", enum={"active","disable","delete"})
 */
class Row extends \Bluz\Db\Row
{
    use Validator;

    /**
     * Before Insert/Update
     *
     * @return void
     */
    protected function beforeSave()
    {
        // name validator
        $this->addValidator('name')
            ->required()
            ->latin(' ');

        // email validator
        $this->addValidator('email')
            ->required()
            ->email();
    }
}
