<?php

use Phinx\Seed\AbstractSeed;

class TestSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $prefix = bin2hex(random_bytes(4));
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $name = uniqid($prefix);
            $data[] = [
                'name'    => $name,
                'email'   => $name . '@localhost.com',
                'status'  => array_rand(['active' => 1, 'disable' => 2, 'delete' => 3]),
                'created' => date('Y-m-d H:i:s'),
            ];
        }

        $this->insert('test', $data);

        $auth = [
            [
                'userId' => 2,
                'provider' => 'token',
                'foreignKey' => 'admin',
                'token' => '$2y$10$wkZxb1sp8TsRXNL2s5KjGuFD58hGJQy4oyihm8xo7OBtV2uH7hQUu',
                'tokenSecret' => 'c8ab812795bb6a2784e30527d5b167fc',
                'tokenType' => 'access',
                'created' => '2015-01-01 00:00:00',
                'updated' => '2015-01-01 00:00:00',
                'expired' => '2025-01-01 00:00:00',
            ]
        ];
        $this->insert('auth', $auth);
    }
}
