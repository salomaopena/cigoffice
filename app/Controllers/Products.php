<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;

class Products extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Productos',
            'page' => 'Produtos'
        ];

        $product_model = new ProductModel();
        $data['products'] = $product_model
            ->where('id_restaurant', session()->user['id_restaurant'])
            ->findAll();
        return view('dashboard/products/index', $data);
    }

    //______________________________
    // New Product
    //______________________________
    public function newProduct(): string
    {
        $data = [
            'title' => 'Productos',
            'page' => 'Novo produto'
        ];
        $data['validation_errors'] = session()->getFlashdata('validation_errors');

        //select disticnt
        $product_model = new ProductModel();

        $data['categories'] = $product_model
            ->where('id_restaurant', session()->user['id_restaurant'])
            ->select('category')->distinct()
            ->findAll();
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

        //check if image equal to no_image.png
        if ($this->request->getFile('file_image')->getName() == 'no_image.png') {
            return redirect()->back()->withInput()->with('validation_errors', ['file_image' => 'Imagem do produto é obrigatória.']);
        }

        //check if products already exists
        $product_model = new ProductModel();
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
        $newName = prefixed_product_file_name($file->getName());
        //save image to public/assets/images/products folder with unique name
        $file->move(ROOTPATH . 'public/assets/images/products', $newName, true);

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

    //______________________________
    // Edit Product
    //______________________________
    public function edit($enc_id)
    {

        $id = Decrypt($enc_id);

        if (empty($id)) {
            return redirect()->to(site_url('products'));
        }

        $data = [
            'title' => 'Productos',
            'page' => 'Editar produto'
        ];

        //validation form
        $data['validation_errors'] = session()->getFlashdata('validation_errors');

        $data['server_error'] = session()->getFlashdata('server_error');

        //get product $data
        $product_model = new ProductModel();

        $data['product'] = $product_model->find($id);

        //get distinct categories
        $data['categories'] = $product_model
            ->where('id_restaurant', session()->user['id_restaurant'])
            ->select('category')->distinct()
            ->findAll();

        //check if the image product exists
        if (empty($data['product']->image)) {
            $data['product']->image = 'no_image.png';
        }

        return view('dashboard/products/edit_product_form', $data);
    }

    public function editSubmit()
    {
        //validation

        $validation = $this->validate([


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
            'text_stock_minimum_limit' => [
                'label' => 'limite mínimo de estoque do produto',
                'rules' => 'required|greater_than[99]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'greater_than' => 'O campo {field} deve ser um número maior que {param}',
                ]
            ]
        ]);

        //check if $id is ok
        $id = Decrypt($this->request->getPost('id_product'));

        if (empty($id)) {
            return redirect()->to(site_url('products'));
        }

        if (!$validation) {
            //dd($this->validator->getErrors());
            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }

        //check if image equal to no_image.png
        if ($this->request->getFile('file_image')->getName() == 'no_image.png') {
            return redirect()->back()->withInput()->with('validation_errors', ['file_image' => 'Imagem do produto é obrigatória.']);
        }

        //check if the product exist
        $product_model = new ProductModel();

        $product = $product_model
            ->where('name', $this->request->getPost('text_name'))
            ->where('id_restaurant', session()->user['id_restaurant'])
            ->where('id !=', $id)
            ->first();

        if ($product) {
            return redirect()->back()->withInput()->with('server_error', 'Nome do produto já existe neste restaurante.');
        }

        //prepere data to update

        $data = [
            'name' => $this->request->getPost('text_name'),
            'description' => $this->request->getPost('text_description'),
            'category' => $this->request->getPost('text_category'),
            'price' => str_replace(',', '.', $this->request->getPost('text_price')),
            'promotion' => $this->request->getPost('text_promotion'),
            'availability' => $this->request->getPost('check_available') ? 1 : 0,
            'stock_min_limit' => $this->request->getPost('text_stock_minimum_limit'),
            //'image' => $newName,

        ];

        //check if the product image was changed
        $file_image = $this->request->getFile('file_image');

        if ($file_image->getName() != '') {

            $prefixed_name = prefixed_product_file_name($file_image->getName());

            $file_image->move(ROOTPATH . 'public/assets/images/products', $prefixed_name, true);

            //update the product image in the database
            $data['image'] = $prefixed_name;
            //delete the old image
            //unlink(ROOTPATH.'public/assets/images/products/'.$this->request->getPost('image_old'));
        }

        //update the product
        $product_model->update($id, $data);

        return redirect()->to(site_url('products'));
    }

    //______________________________
    // Delete Product
    //______________________________

    public function delete($enc_id)
    {
        //check if $id is ok
        $id = Decrypt($enc_id);

        if (empty($id)) {
            return redirect()->to(site_url('products'));
        }

        //check if the product exist
        $product_model = new ProductModel();
        $product = $product_model->find($id);
        if (!$product) {
            return redirect()->to(site_url('products'));
        }

        //show confirm delete product dialog

        $data = [
            'title' => 'Productos',
            'page' => 'Excluir produto',
            'product' => $product,
            'message' => 'Tem certeza que deseja excluir este produto? <strong>É um processo irreversível.</strong>'
        ];

        return view('dashboard/products/delete_product', $data);
    }

    public function deleteConfirm($enc_id)
    {
         //check if $id is ok
         $id = Decrypt($enc_id);

         if (empty($id)) {
             return redirect()->to(site_url('/products'));
         }
 
         //check if the product exist
         $product_model = new ProductModel();
         $product = $product_model->find($id);
         if (!$product) {
             return redirect()->to(site_url('/products'));
         }
        
         //delete the product
         $product_model->delete($id);

         return redirect()->to(site_url('/products'));
    
    }
}
