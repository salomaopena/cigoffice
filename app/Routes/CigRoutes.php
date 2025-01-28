<?php

namespace App\Routes;

use Config\Services;

$routes = Services::routes();


// main routes
$routes->get('/','Main::index');

//login routes

$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/login-submit', 'Auth::login_submit');
$routes->get('/auth/logout', 'Auth::logout');

//dashboard routes
//products routes
$routes->get('/products', 'Products::index');
$routes->get('/products/new', 'Products::newProduct');
$routes->post('/products/new/submit','Products::newSubmit');

//edit product
$routes->get('/products/edit/(:alphanum)', 'Products::edit/$1');
$routes->post('/products/edit/submit','Products::editSubmit');

//delete product
$routes->get('/products/delete/(:alphanum)', 'Products::delete/$1');
$routes->get('/products/delete/confirm/(:alphanum)', 'Products::deleteConfirm/$1');

//stocks
$routes->get('/stocks', 'Stocks::index');
$routes->get('/stocks/product/(:alphanum)', 'Stocks::productStock/$1');
$routes->get('/stocks/add/(:alphanum)', 'Stocks::addStock/$1');
$routes->post('/stocks/add/submit', 'Stocks::SubmitStock');
