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
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'username'      => $faker->userName,
                'email'         => $faker->email,
                'status'        => array_rand(['active' => 1, 'disable' => 2, 'delete' => 3]),
                'created'       => date('Y-m-d H:i:s'),
            ];
        }

        $this->insert('test', $data);
    }
}
