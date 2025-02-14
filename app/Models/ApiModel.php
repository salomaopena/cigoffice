<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class ApiModel extends Model
{
    private $project_id;

    public function __construct($project_id)
    {
        $this->project_id = $project_id;
    }

    public function get_restaurant_details()
    {
        $params = [
            'project_id' => $this->project_id,
        ];
        
        $db = Database::connect();
        $results = $db->query("SELECT * FROM restaurants WHERE 1 AND project_id = :project_id:", $params)->getResultArray();
        return $results;
    }
}
