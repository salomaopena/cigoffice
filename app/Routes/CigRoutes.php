<?php

namespace App\Routes;

use Config\Services;

$routes = Services::routes();


// Defining routes here
$routes->get('/', 'Auth::index');
$routes->get('/teste', 'Auth::teste');
$routes->get('/users', 'Users::index');