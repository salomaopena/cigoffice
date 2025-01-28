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
        $product_model = new ProductModel();
        $products = $product_model->where('id_restaurant', session()->user['id_restaurant'])->findAll();

        $data = [
            'title' => 'Stocks',
            'page' => 'Stocks',
            'products' => $products, //get all products from the database
        ];
        //load product data
        return view('dashboard/stocks/stocks', $data);
    }

    public function addStock($enc_id)
    {
        $id = Decrypt($enc_id);

        if (empty($id)) {
            return redirect()->to(site_url('/stocks'));
        }

        $product_model = new ProductModel();
        $product = $product_model->where('id',$id)->first();

        //implement add stock functionality here
        $data = [
            'title' => 'Adicionar Stock',
            'page' => 'Adicionar Stock',
            'product' => $product, //get product data
        ];
        return view('dashboard/stocks/add_form', $data);
    }

    public function submitStock() {
        //implement stock submission logic here
        //...
        //return redirect()->to('/stocks')->with('success', 'Stock adicionado com sucesso!');
        echo('OK');
    }
}
