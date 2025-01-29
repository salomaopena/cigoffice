<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\StockModel;
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
        $product = $product_model->where('id', $id)->first();

        // get distinct suppliers within stocks table that belongs to this restaurant
        $stock_model = new StockModel();
        $suppliers = $stock_model->get_stock_supplier(session()->user['id_restaurant']);

        print_data($suppliers);

        $data = [
            'title' => 'Adicionar Stock',
            'page' => 'Adicionar Stock',
            'product' => $product, //get product data
            'suppliers' => $suppliers, //get distinct suppliers
        ];

        return view('dashboard/stocks/add_form', $data);
    }

    public function submitStock()
    {
        //implement stock submission logic here
        //...
        //return redirect()->to('/stocks')->with('success', 'Stock adicionado com sucesso!');
        echo ('OK');
    }
}
