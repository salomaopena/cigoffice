<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function login():string
    {
        return view('auth/login-form');
    }

    public function login_submit()
    {
        echo('Login submit');
    }

    public function logout(){
        echo('Estou saindo do sistema...');
    }
}
