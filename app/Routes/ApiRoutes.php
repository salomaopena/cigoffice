<?php

//define the namespace
namespace App\Routes;

//load the necessary service
use Config\Services;

//set the routes collections
$routes = Services::routes();

// api routes
$routes->get('/api/status', 'Api::api_status');
$routes->get('/credencials/(:alphanum)/(:alphanum)', 'Api::create_api_credentials/$1/$2');