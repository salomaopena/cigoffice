<?php

//define the namespace
namespace App\Routes;

//load the necessary service
use Config\Services;

//set the routes collections
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override it later. This file is typically located at

$routes->get('/no_access_allowed', 'Main::noAccessAllowed');

// main routes
$routes->get('/', 'Main::index');

//login routes

$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/login-submit', 'Auth::login_submit');
$routes->get('/auth/logout', 'Auth::logout');
//forgot password
$routes->get('/auth/forgot_password', 'Auth::forgot_password');
$routes->post('/auth/forgot_password_submit', 'Auth::forgot_password_submit');
//reset password
$routes->get('/auth/reset_password/(:alphanum)', 'Auth::reset_password/$1');
$routes->post('/auth/reset_password_submit', 'Auth::reset_password_submit');

//finish registration
$routes->get('/auth/finish_registration/(:alphanum)', 'Auth::finish_registration/$1');
//define password
$routes->get('/auth/define_password', 'Auth::define_password');
$routes->post('/auth/define_password_submit', 'Auth::define_password_submit');
$routes->get('/auth/welcome', 'Auth::welcome');


//profile routes
$routes->get('/auth/profile', 'Auth::profile');
$routes->post('/auth/profile_submit', 'Auth::profile_submit');
$routes->post('/auth/change_password_submit', 'Auth::change_password_submit');

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
$routes->get('/users_management/new', 'UsersManagement::new', ['filter' => 'adminrole']);
$routes->post('/users_management/submit', 'UsersManagement::submit', ['filter' => 'adminrole']);
$routes->get('/users_management', 'UsersManagement::index', ['filter' => 'adminrole']);
$routes->get('/users_management/edit/(:alphanum)', 'UsersManagement::edit/$1', ['filter' => 'adminrole']);
$routes->post('/users_management/edit_submit', 'UsersManagement::edit_submit', ['filter' => 'adminrole']);
$routes->get('/users_management/delete_user/(:alphanum)', 'UsersManagement::delete_user/$1', ['filter' => 'adminrole']);
$routes->get('/users_management/recover_user/(:alphanum)', 'UsersManagement::recover_user/$1', ['filter' => 'adminrole']);
