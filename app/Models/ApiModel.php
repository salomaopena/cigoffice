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


    public function _get_products_availability($data)
    {
        //temporariamente vamos guardar os dados no disco local
        //$file_path = WRITEPATH.'cache/products_availability.json';
        //$data_json = json_encode($data,JSON_PRETTY_PRINT);

        //file_put_contents($file_path, $data_json);

        //return true;

        //get key->value pair for products (id->quantity)
        $products = [];
        foreach ($data as $product) {
            //code to get product availability from your database or API here
            $id = $product['id_product'];
            $quantity = $product['quantity'];
            $products[$id] = $quantity;
        }

        //get data from cache
        //$file_path = WRITEPATH.'cache/products_availability.json';
        //if(file_exists($file_path)){
        //    $data_json = file_get_contents($file_path);
        //    $products_availability = json_decode($data_json, true);
        //}

        //update cache with new data
        //file_put_contents($file_path, json_encode($data,JSON_PRETTY_PRINT));

        //create a string with all the products
        $product_ids = implode(',', array_keys($products));

        //$file_path = WRITEPATH.'cache/products_availability.json';
        //$data_json = json_encode($product_ids,JSON_PRETTY_PRINT);

        //file_put_contents($file_path, $product_ids);

        //return $products_availability;

        //get products from database
        try {
            $db = Database::connect();
            
            $results = $db->query("SELECT * FROM products WHERE 1
            AND id IN ($product_ids)
            AND availability = 1
            AND stock > stock_min_limit
            AND deleted_at IS NULL")->getResult();

            //check if totol products is equal to the total products in request

            if(count($results) != count($products)){
                return [
                   'status' => 'error',
                   'message' => 'Not all products are available in the requested quantity.'
                ];
            }

            //check if the quantity of each product is available
            foreach($results as $product){
                $quantity = $products[$id];
                if($product->stock - $quantity <= $product->stock_min_limit){
                    return [
                       'status' => 'error',
                       'message' => 'Not all products are available in the requested quantity.'
                    ];
                }
            }

            //all products are available

            return [
               'status' =>'success',
               'message' => 'All products are available in the requested quantity.',
               'products_availability' => $products
            ];

        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $ex) {
            return [
                'status' => 'error',
                'message' => $ex->getMessage()
            ];
        }
    }
}
