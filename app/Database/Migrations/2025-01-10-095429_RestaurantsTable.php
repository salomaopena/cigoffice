<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RestaurantsTable extends Migration
{
    public function up()
    {
        //crete restaurant table
        $this->forge->addField([
            'id'=>[
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'name' =>[
                'type'              => 'VARCHAR',
                'constraint'        => 50,
                'null'              => false,
            ],
            'address' =>[
                'type'              => 'VARCHAR',
                'constraint'        => 250,
                'null'              => true,
            ],
            'phone' =>[
                'type'              => 'VARCHAR',
                'constraint'        => 15,
                'null'              => true,
            ],
            'email' =>[
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => false,
            ],
            'created_at' =>[
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'update_at' =>[
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'deleted_at' =>[
                'type'              => 'DATETIME',
                'null'              => true,
            ],
        ]);

        //primary key
        $this->forge->addKey('id',true);

        //create table
        $this->forge->createTable('restaurants');
    }

    public function down()
    {
        //drop table
        $this->forge->dropTable('restaurants');
    }
}
