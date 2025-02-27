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

        //print_data($suppliers);

        $data = [
            'title' => 'Adicionar Stock',
            'page' => 'Adicionar Stock',
            'product' => $product, //get product data
            'suppliers' => $suppliers, //get distinct suppliers
            'validation_errors' => session()->getFlashdata('validation_errors'), //get validation errors if any
            'server_error' => session()->getFlashdata('server_error'), //get server error if any
        ];

        return view('dashboard/stocks/add_form', $data);
    }

    public function submitStock()
    {
        //implement stock submission logic here
        //

        $validation = $this->validate($this->_stock_add_form_validation());

        if (!$validation) {
            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }

        $id_product = Decrypt($this->request->getPost('id_product'));
        if (empty($id_product)) {
            return redirect()->back()->withInput()->with('server_error', 'Ocorreu um erro. Tente novamente!');
        }

        $text_stock = $this->request->getPost('text_stock');
        $text_supplier = $this->request->getPost('text_supplier');
        $text_reason = $this->request->getPost('text_reason');
        $text_date = $this->request->getPost('text_date');
        //validate inputs
        //insert stock data

        $stock_model = new StockModel();
        $stock_model->insert([
            'id_product' => $id_product,
            'stock_quantity' => intval($text_stock),
            'stock_supplier' => $text_supplier,
            'reason' => $text_reason,
            'stock_in_out' => 'IN',
            'moviment_date' => $text_date,
        ]);

        //increament product stock
        $product_model = new ProductModel();
        $product_model
            ->where('id', $id_product)
            ->set('stock', 'stock + ' . intval($text_stock), false)
            ->update();

        return redirect()->to(site_url('/stocks'));
    }

    public function remove($enc_id)
    {
        $id = Decrypt($enc_id);

        if (empty($id)) {
            return redirect()->to(site_url('/stocks'));
        }


        $product_model = new ProductModel();
        $product = $product_model->where('id', $id)->first();


        $data = [
            'title' => 'Remover Stock',
            'page' => 'Remover Stock',
            'product' => $product, //get product data
            'validation_errors' => session()->getFlashdata('validation_errors'), //get validation errors if any
            'server_error' => session()->getFlashdata('server_error'), //get server error if any
        ];

        return view('dashboard/stocks/remove_form', $data);
    }


    public function submitRemoveStock()
    {

        $validation = $this->validate($this->_stock_remove_form_validation());

        if (!$validation) {
            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }

        $id_product = Decrypt($this->request->getPost('id_product'));

        if (empty($id_product)) {
            return redirect()->back()->withInput()->with('server_error', 'Ocorreu um erro. Tente novamente!');
        }

        $text_stock = $this->request->getPost('text_stock');
        $text_reason = $this->request->getPost('text_reason');
        $text_date = $this->request->getPost('text_date');

        $product_model = new ProductModel();
        $product = $product_model->where('id', $id_product)->first();

        if ($product->stock < intval($text_stock)) {
            return redirect()->back()->withInput()->with('server_error', 'O stock atual é inferior a quantidade de stock a remover.');
        }

        $stock_model = new StockModel();
        $stock_model->insert([
            'id_product' => $id_product,
            'stock_quantity' => intval($text_stock),
            'stock_supplier' => 'Owner',
            'reason' => $text_reason,
            'stock_in_out' => 'OUT',
            'moviment_date' => $text_date,
        ]);

        //decrement product stock
        $product_model
            ->where('id', $id_product)
            ->set('stock', 'stock - ' . intval($text_stock), false)
            ->update();

        return redirect()->to(site_url('/stocks'));
    }

    public function moviments($enc_id, $filter = null)
    {
        $id = Decrypt($enc_id);

        if (empty($id)) {
            return redirect()->to(site_url('/stocks'));
        }

        $product_model = new ProductModel();
        $product = $product_model->where('id', $id)->first();

        $stock_model = new StockModel();
        $stock_suppliers = $stock_model->get_stock_supplier(session()->user['id_restaurant']);

        //load movement for the product limited to 10000 records

        $data = [
            'title' => 'Entradas e Saídas',
            'page' => 'Entradas e Saídas',
            'product' => $product, //get product data
            'datatables' => true,
            'movements' => $this->_get_stock_movements($id, $filter),
            'stock_suppliers' => $stock_suppliers,
            'filter' => empty($filter) ? '' : Decrypt($filter),
        ];

        //print_data($data);

        return view('/dashboard/stocks/movements', $data);
    }


    public function exportCSV($enc_id){
        $id_product = Decrypt($enc_id);

        if (empty($id_product)) {
            return redirect()->to(site_url('/stocks'));
        }

        //get stocks movements for this products and export to csv

        $stock_model = new StockModel();
        $movements = $stock_model
            ->where('id_product', $id_product)
            ->orderBy('moviment_date', 'DESC')
            ->findAll();

        //download csv file with stock moviments data

        $this->response->setHeader('Content-Type', 'text/csv; charset=utf-8');
        $this->response->setHeader('Content-Disposition', 'attachment; filename=movements.csv');

        $output = fopen('php://output', 'w');

        //header
        fputcsv($output, ['Data do movimento','Quantidade', 'Operação','Fornecedor','Observações']);

        //body and data

        foreach ($movements as $movement) {
            fputcsv($output,[
                $movement->moviment_date,
                $movement->stock_quantity,
                $movement->stock_in_out,
                $movement->stock_supplier,
                $movement->reason
            ]);
        }
        fclose($output);
    }


    private function _get_stock_movements($id_product, $filter)
    {
        //load movement for the product limited to 10000 records
        //get last 10000 records from stocks table where id_product = $id_product

        $stock_model =  new StockModel();
        $movements = [];

        $filter = Decrypt($filter);

        switch ($filter):
            case '':
                $movements = $stock_model
                    ->where('id_product', $id_product)
                    ->orderBy('moviment_date', 'DESC')
                    ->limit(10000)
                    ->findAll();
                break;
            case 'IN':
                $movements = $stock_model
                    ->where('id_product', $id_product)
                    ->where('stock_in_out', 'IN')
                    ->orderBy('moviment_date', 'DESC')
                    ->limit(10000)
                    ->findAll();
                break;
            case 'OUT':
                $movements = $stock_model
                    ->where('id_product', $id_product)
                    ->where('stock_in_out', 'OUT')
                    ->orderBy('moviment_date', 'DESC')
                    ->limit(10000)
                    ->findAll();
                break;
            case substr($filter, 0, 6) == 'stksup':
                $supplier = substr($filter, 7);
                $movements = $stock_model
                    ->where('id_product', $id_product)
                    ->where('stock_supplier', $supplier)
                    ->orderBy('moviment_date', 'DESC')
                    ->limit(10000)
                    ->findAll();
                break;
            default:
                $movements = $stock_model
                    ->where('id_product', $id_product)
                    ->orderBy('moviment_date', 'DESC')
                    ->limit(10000)
                    ->findAll();
        endswitch;

        return $movements;
    }


    private function _stock_add_form_validation()
    {
        return [
            'id_product' => [
                'rules' => 'required',
            ],
            'text_stock' => [
                'label' => 'Quantidade',
                'rules' => 'required|integer|greater_than[0]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório.',
                    'integer' => 'O campo {field} precisa ser um número inteiro.',
                    'greater_than' => 'O campo {field} precisa ser um número maior que {param}.'
                ]
            ],
            'text_supplier' => [
                'label' => 'Fornecedor',
                'rules' => 'required',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório.'
                ]
            ],
            //'text_reason' not required
            'text_date' => [
                'label' => 'Data do movimento',
                'rules' => 'required|valid_date[Y-m-d H:i]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório.',
                    'valid_date' => 'O campo {field} precisa ser uma data e hora válida (AAAA-MM-DD HH:MM).'
                ]
            ]
        ];
    }

    private function _stock_remove_form_validation()
    {
        return [
            'id_product'    => [
                'rules'     => 'required',
            ],
            'text_stock'    => [
                'label'     => 'Quantidade',
                'rules'     => 'required|integer|greater_than[0]',
                'errors'    => [
                    'required'    => 'O campo {field} é obrigatório.',
                    'integer'     => 'O campo {field} precisa ser um número inteiro.',
                    'greater_than' => 'O campo {field} precisa ser um número maior que {param}.'
                ]
            ],
            //'text_reason' not required
            'text_date'     => [
                'label'     => 'Data do movimento',
                'rules'     => 'required|valid_date[Y-m-d H:i]',
                'errors'    => [
                    'required'      => 'O campo {field} é obrigatório.',
                    'valid_date'    => 'O campo {field} precisa ser uma data e hora válida (AAAA-MM-DD HH:MM).'
                ]
            ]
        ];
    }
}
