<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Products extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Productos',
            'page' => 'Produtos'
        ];
        return view('dashboard/products/index',$data);
    }

    public function new_product():string{
        $data = [
            'title' => 'Productos',
            'page' => 'Novo produto'
        ];
        return view('dashboard/products/new_product_form',$data);
    }
}
