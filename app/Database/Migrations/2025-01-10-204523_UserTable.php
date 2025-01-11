<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserTable extends Migration
{
    public function up()
    {
        //create fields
        $this->forge->addField([
            'id'=>[
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true,
                'comment'           => 'Primary Key',
            ],
            'id_restaurant'=>[
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'first_name' =>[
                'type'              => 'VARCHAR',
                'constraint'        => 50,
                'null'              => true,
            ],'last_name' =>[
                'type'              => 'VARCHAR',
                'constraint'        => 50,
                'null'              => true,
            ],
            'full_name' =>[
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => true,
            ],'username' =>[
                'type'              => 'VARCHAR',
                'constraint'        => 50,
                'null'              => false,
                'unique'            => true,
            ],
            'email' =>[
                'type'              => 'VARCHAR',
                'constraint'        => 50,
                'null'              => true,
                'unique'            => true,
            ],
            'passwrd' =>[
                'type'              => 'VARCHAR',
                'constraint'        => 250,
                'null'              => false,
            ],
            'roles' =>[
                'type'              => 'VARCHAR',
                'constraint'        => 500,
                'null'              => true,
            ],
            'blocked_until' =>[
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'is_active' =>[
                'type'              => 'INT',
                'constraint'        => 1,
                'null'              => true,
            ],
            'code' =>[
                'type'              => 'VARCHAR',
                'constraint'        => 20,
                'null'              => true,
            ],
            'last_login' =>[
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'created_at' =>[
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'updated_at' =>[
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'deleted_at' =>[
                'type'              => 'DATETIME',
                'null'              => true,
            ],
        ]);
        //primary key
        $this->forge->addKey('id', true);

        //create table
        $this->forge->createTable('users');
    }

    public function down()
    {
        //Rolback
        $this->forge->dropTable('users');
    }
}
