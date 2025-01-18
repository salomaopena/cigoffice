<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'id_restaurant' =>[
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'name'=>[
                'type'              => 'VARCHAR',
                'constraint'        => 150,
                'null'              => false,
            ],
            'description'=>[
                'type'              => 'TEXT',
                'null'              => true,
            ],
            'category' =>[
                'type'              => 'VARCHAR',
                'constraint'        => 50,
                'null'              => true,
            ],
            'price'=>[
                'type'              => 'DECIMAL',
                'constraint'        => '10,2',
                'null'              => true,
                'default'           => 0.00,
            ],
            'availability'=>[
                'type'              => 'BOOLEAN',
                'null'              => false,
                'default'           => 1,
            ],
            'promotion'=>[
                'type'              => 'DECIMAL',
                'constraint'        => '5,2',
                'null'              => true,
                'default'           => 0.00,
            ],
            'stock'=>[
                'type'              => 'INT',
                'constraint'        => 11,
                'null'              => true,
                'default'           => 0,
            ],
            'stock_min_limit' =>[
                'type'              => 'INT',
                'constraint'        => 11,
                'null'              => true,
                'default'           => 10,
            ],
            'image'=>[
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => true,
            ],
            'created_at'=>[
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'updated_at'=>[
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'deleted_at'=>[
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            
        ]);
        //primary key
        $this->forge->addKey('id', true);
        //foreign key
        //$this->forge->addForeignKey('id_restaurant','restaurants','id');
        //create table
        $this->forge->createTable('products');
    }

    public function down()
    {
        //drop table
        $this->forge->dropTable('products');
    }
}
