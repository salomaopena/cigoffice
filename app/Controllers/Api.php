<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ApiResponse;
use CodeIgniter\HTTP\ResponseInterface;

class Api extends BaseController
{

    public function create_api_credentials($project_id, $api_key){

        $response = new ApiResponse();

         //check if project_id and api_key are valid
        if(empty($project_id) | empty($api_key)){
            return $response->set_response_error(400, 'Missing required parameters');
        }

        echo "<pre>";
        echo "project_id: $project_id<br>";
        echo "api_key: $api_key<br>";
        echo "api key (hash): ".password_hash($api_key,PASSWORD_DEFAULT). "<br>";
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
    public function api_status()
    {
        $response = new ApiResponse();
        $response->validade_request('GET');
        return $response->set_response();
    }
}
