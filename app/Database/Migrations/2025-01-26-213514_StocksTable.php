<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StocksTable extends Migration
{
    public function up()
    {
        // Create stocks table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_product' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'stock_quantity' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'stock_in_out' => [
                'type' => 'VARCHAR',
                'constraint' => 5,  // IN or OUT
                'null' => true,
            ],
            'stock_supplier' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'reason' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'moviment_date'=>[
                'type' => 'DATETIME',
                'null' => true,
            ],
            // Timestamps
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Add primary key
        $this->forge->addKey('id', true);

        // Create stocks table
        $this->forge->createTable('stocks');
    }

    public function down()
    {
        //
        $this->forge->dropTable('stocks');
    }
}

