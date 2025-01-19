<?php

namespace App\Routes;

use Config\Services;

$routes = Services::routes();


// main routes
$routes->get('/','Main::index');

//login routes

$routes->get('auth/login', 'Auth::login');
$routes->post('auth/login-submit', 'Auth::login_submit');
$routes->get('auth/logout', 'Auth::logout');

//dashboard routes
//products routes
$routes->get('products', 'Products::index');
$routes->get('products/new', 'Products::newProduct');
$routes->post('products/new/submit','Products::newSubmit');