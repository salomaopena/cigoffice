<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrdersTable extends Migration
{
    public function up()
    {
        // create order table
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_restaurant' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'order_number' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'order_date' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'order_status' => [
                'type' => 'varchar',
                'constraint' => 50,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'datetime',
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ]);

        // primary key
        $this->forge->addKey('id', true);

        // create table
        $this->forge->createTable('orders');
    }

    public function down()
    {
        // drop table
        $this->forge->dropTable('orders');
    }
}
