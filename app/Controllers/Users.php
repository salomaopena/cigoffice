<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Users extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $results = $db -> query('SELECT * FROM users') ->getResult();
        $data = [
            'title' =>'Usuários',
            'users' => $results,
        ];
        return view('users',$data);

    }
}
