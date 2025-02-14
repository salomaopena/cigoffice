<?php

namespace App\Models;

use App\Libraries\ApiResponse;
use CodeIgniter\Model;
use Config\Database;

class ApiModel extends Model
{
    private $project_id;

    public function __construct($project_id)
    {
        $this->project_id = $project_id;
    }

    private function _sql_error($e)
    {
        if (API_DEBUG_LEVEL == 1) {
            $response = new ApiResponse();
            die($response->set_response_error(500, $e->getMessage()));
        } else {
            $response = new ApiResponse();
            die($response->set_response_error(500, 'Internal Server Error!!!'));
        }
    }

    public function get_restaurant_details()
    {
        try {
            //code...
            $db = Database::connect();
            $data = [];

            $params = ['project_id' => $this->project_id];

            //get restaurant details
            $results = $db->query("SELECT * FROM restaurants WHERE 1 AND project_id = :project_id: AND deleted_at IS NULL", $params);
            $data['restaurant_details'] = $results->getResult()[0];


            //get products categories
            $results = $db->query("SELECT DISTINCT (p.category) category FROM products p JOIN restaurants r ON p.id_restaurant = r.id WHERE r.project_id = :project_id: AND p.deleted_at IS NULL ", $params);
            $data['products_categories'] = $results->getResult();

            //get popular products
            $results = $db->query("SELECT p.* FROM products p JOIN restaurants r ON p.id_restaurant = r.id WHERE r.project_id = :project_id: AND p.deleted_at IS NULL ", $params);
            $data['products'] = $results->getResult();

            //get stock details
            //$results = $db->query("",$params);
            //$data['stock_details'] = $results->getResult();

            //get sales history
            //$results = $db->query("",$params);
            //$data['sales_history'] = $results->getResult();

            //get reviews
            //$results = $db->query("",$params);
            //$data['reviews'] = $results->getResult();

            //get opening hours
            //$results = $db->query("",$params);
            //$data['opening_hours'] = $results->getResult();

            //get social media links
            //$results = $db->query("",$params);
            //$data['social_media_links'] = $results->getResult();

            //get special offers
            //$results = $db->query("",$params);

            return $data;
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $this->_sql_error($e);
        }
    }
}
