<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ApiResponse;
use App\Models\ApiModel;
use CodeIgniter\HTTP\ResponseInterface;

class Api extends BaseController
{

    public function create_api_credentials($project_id, $api_key)
    {

        $response = new ApiResponse();

        //check if project_id and api_key are valid
        if (empty($project_id) | empty($api_key)) {
            return $response->set_response_error(400, 'Missing required parameters');
        }

        echo "<pre>";
        echo "project_id: $project_id<br>";
        echo "api_key: $api_key<br>";
        echo "api key (hash): " . password_hash($api_key, PASSWORD_DEFAULT) . "<br>";
        echo "</pre>";

        $data = [
            'project_id' => $project_id,
            'api_key' => $api_key
        ];

        //encrypt the hash key
        $encrypter = \Config\Services::encrypter();
        $encrypted_key = bin2hex($encrypter->encrypt(json_encode($data)));

        echo $encrypted_key;
    }


    private function _get_project_id()
    {
        $header = $this->request->getHeaderLine('X-API-CREDENCIALS');
        $encripter = \Config\Services::encrypter();
        $credencials = json_decode($encripter->decrypt(hex2bin($header)), true);
        return $credencials['project_id'];
    }

    //========================================================================================//
    //                                  API ENDPOINTS                                         //
    //========================================================================================//
    public function api_status()
    {
        $response = new ApiResponse();
        $response->validade_request('GET');
        return $response->set_response(200, 'success', [], $this->_get_project_id());
    }


    public function restaurant_details()
    {
        response()->setContentType('application/json');
        $response = new ApiResponse();
        $response->validade_request('GET');
        $api = new ApiModel($this->_get_project_id());

        $data = $api->get_restaurant_details();
        return $response->set_response(
            200,
            'success',
            $data,
            $this->_get_project_id()
        );
    }

    public function checkout()
    {
        response()->setContentType('application/json');
        $response = new ApiResponse();
        $response->validade_request('POST');


        $data = $this->request->getJSON(true);


        //validate checkout data

        $analisys = $this->_analyse_request_data($data);

        if ($analisys['status'] =='error') {
            return $response->set_response_error(
                400, 
                $analisys['message'],
                [],
                $this->_get_project_id()
            );
        }

        //analise request data for products availability

        $analisys = $this->_analyse_order_products_availability($data);

        if ($analisys['status'] =='error') {
            return $response->set_response_error(
                400, 
                $analisys['message'],
                [],
                $this->_get_project_id()
            );
        }

        //if analysis is successfuly

        return $response->set_response(
            200,
            'Success',
            $data,
            $this->_get_project_id()
        );
    }

    private function _analyse_request_data($data)
    {
        //validate data
        //restaurant id
        if (!isset($data['restaurant_id'])) {
            return [
                'status' => 'error',
                'message' => 'Missing restaurant_id'
            ];
        }

        //check order items values
        if (!isset($data['order']['items'])) {
            return [
                'status' => 'error',
                'message' => 'order.items is missing'
            ];
        }

        if (!isset($data['order']['status'])) {
            return [
                'status' => 'error',
                'message' => 'order.status is missing'
            ];
        }

        if (($data['order']['status']) != 'paid') {
            return [
                'status' => 'error',
                'message' => 'order.status must be paid'
            ];
        }

        //check if order contains machine id

        if (!isset($data['machine_id'])) {
            return [
                'status' => 'error',
                'message' => 'machine_id is missing'
            ];
        }

        // if everythin is ok
        return [
           'status' => 'success',
           'message' => 'Request data is valid',
        ];
    }

    private function _analyse_order_products_availability($data){
        //validate order items availability
        $api = new ApiModel($this->_get_project_id());
        
        //get orde product from api request
        $order_products = [];

        foreach ($data['order']['items'] as $id => $item) {

            $temp['id_product'] = $id;
            $temp['quantity'] = $item['quantity'];
            //$temp['price'] = $item['price'];
            $order_products[] = $temp;
        }

        //get products from database
        $results = $api->_get_products_availability($order_products);
        return $results;
    
    }

    public function final_confirmation(){
        response()->setContentType('application/json');
        $response = new ApiResponse();
        $response->validade_request('POST');

        $data = $this->request->getJSON(true);

        //validate final confirmation data
        //colect data from request

        // $file_path = WRITEPATH.'cache/final_confirmation.json';
        // $data_json = json_encode($data,JSON_PRETTY_PRINT);

        // file_put_contents($file_path, $data_json);

        $id_restaurant = $data['id_restaurant'];
        $machine_id = $data['machine_id'];
        $total_price = $data['total_price'];
        $order_items = $data['order']['items'];
        $status = $data['order']['status'];

        $api_model = new ApiModel($this->_get_project_id());
        
        //get the last number from the active restaurant
        
        $order_number = $api_model->get_last_order_number($id_restaurant);
        $order_number++;

        
        //add order to database and get id (order id)
        $results_order = $api_model->add_order($id_restaurant,$machine_id,$total_price,$status, $order_number);

        //on error
        if($results_order['status'] == 'error'){
            return $response->set_response_error(400, $results_order['message'], [], $this->_get_project_id());
        }

        //on success
        $order_id = $results_order['id_order'];

        //add order items to database
        $results_order_items = $api_model->add_order_items($order_id, $order_items);

        //on error
        if($results_order_items['status'] == 'error'){
            return $response->set_response_error(400, $results_order_items['message'], [], $this->_get_project_id());
        }

        //if everything is ok
        return $response->set_response(200, 'success', ['id_order'=>$order_id,'order_number'=>$order_number], $this->_get_project_id());
    }


    /*
    =================================================================
    KITCHEN ROUTES
    =================================================================
    */
    public function get_pending_orders(){
        response()->setContentType('application/json');
        $response = new ApiResponse();
        $response->validade_request('GET');

        $api_model = new ApiModel($this->_get_project_id());
        $results = $api_model->get_pending_orders();


        //on error
        if($results['status'] == 'error'){
            return $response->set_response_error(400, $results['message'], [], $this->_get_project_id());
        }

        //on success
        return $response->set_response(200, 'success', $results['data'], $this->_get_project_id());
    }
}
