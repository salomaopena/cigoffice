<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        //create users data
        $users = [
            [
                'id_restaurant' =>  1,
                'first_name'    =>  'Administrador',
                'last_name'     =>  'Restaurante 1',
                'full_name'     =>  'Aministrador Restaurante 1',
                'username'      =>  'admin1',
                'email'         =>  'admin1@email.com',
                'phone'         =>  '123456789',
                'passwrd'      =>  password_hash('admin1', PASSWORD_DEFAULT),
                'roles'         =>  '["administrador"]',
                'is_active'     =>  1,
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
            [
                'id_restaurant' =>  2,
                'first_name'    =>  'Administrador',
                'last_name'     =>  'Restaurante 2',
                'full_name'     =>  'Aministrador Restaurante 2',
                'username'      =>  'admin2',
                'email'         =>  'admin2@email.com',
                'phone'         =>  '987654321',
                'passwrd'      =>  password_hash('admin2', PASSWORD_DEFAULT),
                'roles'         =>  '["administrador"]',
                'is_active'     =>  1,
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
            [
                'id_restaurant' =>  3,
                'first_name'    =>  'Administrador',
                'last_name'     =>  'Restaurante 3',
                'full_name'     =>  'Aministrador Restaurante 3',
                'username'      =>  'admin3',
                'email'         =>  'admin3@email.com',
                'phone'         =>  '321654987',
                'passwrd'      =>  password_hash('admin3', PASSWORD_DEFAULT),
                'roles'         =>  '["administrador"]',
                'is_active'     =>  1,
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
            [
                'id_restaurant' =>  1,
                'first_name'    =>  'User 1',
                'last_name'     =>  'Restaurante 1',
                'full_name'     =>  'Aministrador Restaurante 2',
                'username'      =>  'user1',
                'email'         =>  'user1@email.com',
                'phone'         =>  '123056489',
                'passwrd'      =>  password_hash('user1', PASSWORD_DEFAULT),
                'roles'         =>  '["user"]',
                'is_active'     =>  1,
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
            [
                'id_restaurant' =>  2,
                'first_name'    =>  'User 2',
                'last_name'     =>  'Restaurante 2',
                'full_name'     =>  'Aministrador Restaurante 2',
                'username'      =>  'user2',
                'email'         =>  'user2@email.com',
                'phone'         =>  '103056789',
                'passwrd'      =>  password_hash('user2', PASSWORD_DEFAULT),
                'roles'         =>  '["user"]',
                'is_active'     =>  1,
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],[
                'id_restaurant' =>  3,
                'first_name'    =>  'User 1',
                'last_name'     =>  'Restaurante 3',
                'full_name'     =>  'Aministrador Restaurante 3',
                'username'      =>  'user3',
                'email'         =>  'user3@email.com',
                'phone'         =>  '120056789',
                'passwrd'      =>  password_hash('user3', PASSWORD_DEFAULT),
                'roles'         =>  '["user"]',
                'is_active'     =>  1,
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
            //... more users...
        ];

        $this->db->table('users')->insertBatch($users);

        echo(PHP_EOL. 'Inseridos ' . count($users). ' utilizadores'.PHP_EOL);
    }
}
