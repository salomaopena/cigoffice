<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RestaurantsSeeder extends Seeder
{
    public function run()
    {
        //create restaurants data
        $restaurants = [
            [
                'name'          =>  'Restaurante 1',
                'address'       =>  'Rua ABC, cidade ABC',
                'phone'         =>  '+55 (34)-123456789',
                'email'         =>  'restaurante1@email.com',
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
            [
                'name'          =>  'Restaurante 2',
                'address'       =>  'Rua ABC, cidade ABC',
                'phone'         =>  '+55 (34)-123456789',
                'email'         =>  'restaurante2@email.com',
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
            [
                'name'          =>  'Restaurante 3',
                'address'       =>  'Rua ABC, cidade ABC',
                'phone'         =>  '+55 (34)-123456789',
                'email'         =>  'restaurante3@email.com',
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
            [
                'name'          =>  'Restaurante 4',
                'address'       =>  'Rua ABC, cidade ABC',
                'phone'         =>  '+55 (34)-123456789',
                'email'         =>  'restaurante4@email.com',
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
        ];

        //insert data into restaurant table
        $this->db->table('restaurants')->insertBatch($restaurants);

        echo(PHP_EOL. 'Inseridos ' . count($restaurants). ' restautantes'.PHP_EOL);
    }
}
