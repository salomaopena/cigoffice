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
        return view('dashboard/products/index', $data);
    }

    public function newProduct(): string
    {
        $data = [
            'title' => 'Productos',
            'page' => 'Novo produto'
        ];
        $data['validation_errors'] = session()->getFlashdata('validation_errors');

        return view('dashboard/products/new_product_form', $data);
    }

    public function newSubmit()
    {
        //validation

        $validation = $this->validate([
            //products image
            'file_image' => [
                'label' => 'imagem do produto',
                'rules' => [
                    'uploaded[file_image]',
                    'mime_in[file_image,image/png,image/jpg,image/jpeg]',
                    'max_size[file_image,1024]'
                ],
                'errors' => [
                    'uploaded' => 'O campo {field} é obrigatório',
                    'mime_in' => 'O campo {field} deve ser uma imagem PNG e JPG',
                    'max_size' => 'O campo {field} deve ter no máximo 1MB'
                ]
            ],

            // input fields
            'text_name' => [
                'label' => 'nome do produto',
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'min_length' => 'O campo {field} deve ter no mínimo 3 caracteres',
                    'max_length' => 'O campo {field} deve ter no máximo 100 caracteres'
                ]
            ],
            'text_description' => [
                'label' => 'descrição do produto',
                'rules' => 'required|min_length[3]|max_length[200]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'min_length' => 'O campo {field} deve ter no mínimo 3 caracteres',
                    'max_length' => 'O campo {field} deve ter no máximo 200 caracteres'
                ]
            ],
            'text_category' => [
                'label' => 'categoria do produto',
                'rules' => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'min_length' => 'O campo {field} deve ter no mínimo 3 caracteres',
                    'max_length' => 'O campo {field} deve ter no máximo 50 caracteres'
                ]
            ],
            'text_price' => [
                'label' => 'preço do produto',
                'rules' => 'required|regex_match[/^\d+\,\d{2}$/]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'regex_match' => 'O campo {field} deve ser um número com o formato x,xx',
                ]
            ],
            'text_promotion' => [
                'label' => 'promoção do produto',
                'rules' => 'required|greater_than[-1]|less_than[100]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'greater_than' => 'O campo {field} deve ser um número maior que {param}',
                    'less_than' => 'O campo {field} deve ser um número menor que {param}',
                ]
            ],
            'text_initial_stock' => [
                'label' => 'estoque inicial do produto',
                'rules' => 'required|greater_than[99]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'greater_than' => 'O campo {field} deve ser um número maior que {param}',
                ]
            ],
            'text_stock_minimum_limit' => [
                'label' => 'limite mínimo de estoque do produto',
                'rules' => 'required|greater_than[99]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'greater_than' => 'O campo {field} deve ser um número maior que {param}',
                ]
            ]
        ]);

        if (!$validation) {
            //dd($this->validator->getErrors());
            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }

        //check if products already exists
        $product_model = new \App\Models\ProductModel();
        //check if name already exists in the same restaurant
        $product = $product_model
            ->where('name', $this->request->getPost('text_name'))
            ->where('id_restaurant', session()->user['id_restaurant'])
            ->first();
        if ($product) {
            return redirect()->back()->withInput()->with('validation_errors', ['text_name' => 'Nome do produto já existe neste restaurante.']);
        }

        //upload the image
        $file = $this->request->getFile('file_image');
        $newName = $file->getName();
        $file->move(ROOTPATH.'public/assets/images/products', $newName, true);

        //store the data in the database

        $data = [
            'id_restaurant' => session()->user['id_restaurant'],
            'name' => $this->request->getPost('text_name'),
            'description' => $this->request->getPost('text_description'),
            'category' => $this->request->getPost('text_category'),
            'price' => str_replace(',', '.', $this->request->getPost('text_price')),
            'promotion' => $this->request->getPost('text_promotion'),
            //'availability' => $this->request->getPost('check_available'),
            'stock' => $this->request->getPost('text_initial_stock'),
            'stock_min_limit' => $this->request->getPost('text_stock_minimum_limit'),
            'image' => $newName,

        ];

        //product insert data
        $product_model->insert($data);
        //redirect to products list
        return redirect()->to(site_url('products'));
    }
}
