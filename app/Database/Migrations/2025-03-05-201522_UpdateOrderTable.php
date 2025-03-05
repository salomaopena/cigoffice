<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateOrderTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('orders',[
            'machine_id' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'id_restaurant',
            ],
            'total_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'default' => 0.00,
                'after' => 'order_status',
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('orders',['machine_id','total_price']);
    }
}
