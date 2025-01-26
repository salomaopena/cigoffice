<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;

class Stocks extends BaseController
{
    public function index()
    {
        //prepare page data
        $product_model = New ProductModel();
        $products = $product_model->where('id_restaurant',session()->user['id_restaurant'])->findAll();
        
        $data = [
            'title' => 'Stocks',
            'page' => 'Stocks',
            'products' => $products, //get all products from the database
        ];
        //load product data
        return view('dashboard/stocks/stocks', $data);
    }
}
