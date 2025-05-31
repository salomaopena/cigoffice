<?php

//define the namespace
namespace App\Routes;

//load the necessary service

use App\Libraries\ApiResponse;
use Config\Services;

//set the routes collections
$routes = Services::routes();

// api routes
$routes->get('/api/status/',            'Api::api_status');
$routes->get('/credencials/(:alphanum)/(:alphanum)', 'Api::create_api_credentials/$1/$2');
$routes->get('/api/restaurant/',        'Api::restaurant_details');
$routes->post('/api/checkout/',          'Api::checkout');
$routes->post('/api/final_confirmation/',          'Api::final_confirmation');
$routes->get('/api/get_pending_orders', 'Api::get_pending_orders');

// delete order
$routes->post('/api/get_order_details/', 'Api::get_order_details');
$routes->post('/api/delete_order/', 'Api::delete_order');


//api route does not exist
$routes->set404Override(function(){
    response()->setContentType('application/json');
    $response = new ApiResponse();
    return $response->set_response_error(404,'Api route does not exist!!!');
});