<?php

//define the namespace
namespace App\Routes;

//load the necessary service
use Config\Services;

//set the routes collections
$routes = Services::routes();


// main routes
$routes->get('/', 'Main::index');

//login routes

$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/login-submit', 'Auth::login_submit');
$routes->get('/auth/logout', 'Auth::logout');

//finish registration
$routes->get('/auth/finish_registration/(:alphanum)', 'Auth::finish_registration/$1');
//define password
$routes->get('/auth/define_password', 'Auth::define_password');
$routes->post('/auth/define_password_submit', 'Auth::define_password_submit');
$routes->get('/auth/welcome', 'Auth::welcome');


//profile routes
$routes->get('/auth/profile', 'Auth::profile');

//dashboard routes
//products routes
$routes->get('/products', 'Products::index');
$routes->get('/products/new', 'Products::newProduct');
$routes->post('/products/new/submit', 'Products::newSubmit');

//edit product
$routes->get('/products/edit/(:alphanum)', 'Products::edit/$1');
$routes->post('/products/edit/submit', 'Products::editSubmit');

//delete product
$routes->get('/products/delete/(:alphanum)', 'Products::delete/$1');
$routes->get('/products/delete/confirm/(:alphanum)', 'Products::deleteConfirm/$1');

//stocks
$routes->get('/stocks', 'Stocks::index');
$routes->get('/stocks/add/(:alphanum)', 'Stocks::addStock/$1');
$routes->post('/stocks/add/submit', 'Stocks::submitStock');
$routes->get('/stocks/remove/(:alphanum)', 'Stocks::remove/$1');
$routes->post('/stocks/remove/submit', 'Stocks::submitRemoveStock');
$routes->get('/stocks/moviments/(:alphanum)', 'Stocks::moviments/$1');
$routes->get('/stocks/moviments/(:alphanum)/(:alphanum)', 'Stocks::moviments/$1/$2');
$routes->get('/stocks/export_csv/(:alphanum)', 'Stocks::exportCSV/$1');


//users management
$routes->get('/users_management/new', 'UsersManagement::new');
$routes->post('/users_management/submit', 'UsersManagement::submit');
$routes->get('/users_management', 'UsersManagement::index');
$routes->get('/users_management/edit/(:alphanum)', 'UsersManagement::edit/$1');
$routes->post('/users_management/edit_submit', 'UsersManagement::edit_submit');
$routes->get('/users_management/delete_user/(:alphanum)', 'UsersManagement::delete_user/$1');
$routes->get('/users_management/recover_user/(:alphanum)', 'UsersManagement::recover_user/$1');
