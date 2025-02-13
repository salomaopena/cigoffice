<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateRestaurantsTable extends Migration
{
    public function up()
    {
        //update restaurants table
        $this->forge->addColumn('restaurants', [
            'project_id' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
                'after' => 'email',
            ],
            'api_key' =>[
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true,
                'after' => 'project_id',
            ]
        ]);

        //add foreign key
    }

    public function down()
    {
        //
        $this->forge->dropColumn('restaurants', ['project_id', 'api_key']);
    }
}
