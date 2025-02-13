<?php

namespace App\Filters;

use App\Libraries\ApiResponse;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiAuth implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        //use this method to create a hash key

        //$this->_create_test_credencials();

        //check if the request contains an encrypted hash key

        $response =  new ApiResponse();

        $data = $request->getHeaderLine('X-API-CREDENCIALS');

        $project_id = null;
        $api_key  = null;

        try {
            //decrypt the hash key
            $encrypter = \Config\Services::encrypter();
            $credencials = json_decode($encrypter->decrypt(hex2bin($data)), true);
            $project_id = $credencials['project_id'];
            $api_key = $credencials['api_key'];

            //check in database if hash is valid

            $db = \Config\Database::connect();
            $query = $db->table('restaurants')
                ->where('project_id', $project_id)
                ->where('deleted_at', null)
                ->get();
            // if the hash is valid, continue with the request
            if (empty($query)) {
                //api-key is not valid, return 401 code, Unauthorized request 
                echo ($response->set_response_error(401, 'Unauthorized request'));
                die(1);
            }

            //check if the api_key is valid
            $row = $query->getRow();
            if (!password_verify($api_key, $row->api_key)) {
                //api-key is not valid, return 401 code, Unauthorized request
                echo ($response->set_response_error(401, 'Unauthorized request'));
                die(1);
            }

        } catch (\Exception $ex) {
            //hash key is not valid or encrypted
            echo ($response->set_response_error(401, 'Unauthorized request'));
            die(1);
        }


        // var_dump([
        //     'project_id' => $credencials['project_id'],
        //     'api_key' => $credencials['api_key'],
        //     'request_method' => $request->getMethod()
        // ]);
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }

    private function _create_test_credencials()
    {
        $encrypter = \Config\Services::encrypter();

        $project_id = 2;
        $api_key = '2Kedc_Q1$*_t4Fz^Vy1$5D9Sv8-fg!55';

        $credencials = json_encode([
            'project_id' => $project_id,
            'api_key' => $api_key,
        ]);
        $encrypted_credencials = bin2hex($encrypter->encrypt($credencials));

        echo $encrypted_credencials;
        die(1);
    }
}