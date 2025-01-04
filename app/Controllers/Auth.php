<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index():string
    {
        return view('auth/login-form');
    }

    public function teste():string 
    {
        return view('teste');
    }
}
