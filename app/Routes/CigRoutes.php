<?php

namespace App\Routes;

use Config\Services;

$routes = Services::routes();


// Defining routes here
$routes->get('/', 'Auth::index');