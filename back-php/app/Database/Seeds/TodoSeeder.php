<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class TodoSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 10; $i++) { //to add 10 clients. Change limit as desired
            $this->db->table('todo')->insert($this->generateTodo());
        }
    }

    private function generateTodo(): array
    {
        $faker = Factory::create();
        return [
            'name' => $faker->name(),
            'DONE' => random_int(0, 1)
        ];
    }
}