<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersManagementModel;
use CodeIgniter\HTTP\ResponseInterface;

class UsersManagement extends BaseController
{
    public function index()
    {
        //
        $data = [
            'title' => 'Gestão de Usuários',
            'page'  => 'Usuários',
        ];

        $users_model = new UsersManagementModel();
        //$users = $users_model->findAll();
        $users = $users_model->select('users.*,restaurants.name AS restaurant_name')->join('restaurants', 'restaurants.id = users.id_restaurant', 'left')
            ->where('id_restaurant', session()->user['id_restaurant']) // Exclude soft-deleted users
            ->findAll();
        $data['users'] = $this->_prepare_users_data($users);
        $data['datatables'] = true;

        return view('dashboard/users_management/index', $data);
    }

    private function _prepare_users_data($users)
    {
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id'            => $user->id,
                'first_name'    => $user->first_name,
                'last_name'     => $user->last_name,
                'full_name'     => $user->first_name . ' ' . $user->last_name,
                'username'      => $user->username,
                'has_password' => !empty($user->passwrd),
                'phone'         => $user->phone,
                'email'         => $user->email,
                'roles'          => json_decode($user->roles),
                'blocked_until' => $user->blocked_until,
                'is_active'     => $user->is_active,
                'last_login'    => $user->last_login,
                'created_at'    => $user->created_at,
                'updated_at'    => $user->updated_at,
                'deleted_at'    => $user->deleted_at,
                'restaurant_name' => $user->restaurant_name,

            ];
        }
        return $data;
    }

    /**
     * Display the form to create a new user.
     *
     * @return string
     */
    public function new()
    {
        $data = [
            'title' => 'Novo Usuário',
            'page'  => 'Usuários',
        ];

        $data['validation_errors'] = session()->getFlashdata('validation_errors');
        $data['server_error'] = session()->getFlashdata('server_error');

        return view('dashboard/users_management/new', $data);
    }


    /**
     * Handle the submission of the new user form.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function submit()
    {

        // Validate the input data
        $validation = $this->validate($this->_new_user_validation());

        if (!$validation) {
            // If validation fails, redirect back with input and errors
            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }

        echo "User submitted successfully!"; // For debugging purposes


        $users_model = new UsersManagementModel();

        $id_restaurant = session()->user['id_restaurant'];
        // Prepare the data for insertion
        $username   = $this->request->getPost('text_username');
        $email      = $this->request->getPost('text_email');
        $phone      = $this->request->getPost('text_phone');

        $results = $users_model->where('id_restaurant', $id_restaurant)
            ->where('username', $username)
            ->orWhere('email', $email)
            ->orWhere('phone', $phone)
            ->findAll();

        if (!empty($results)) {
            // If a user with the same username or email already exists, redirect back with an error
            return redirect()->back()->withInput()->with('server_error', 'Usuário ou email ou celular já existe.');
        }

        // inser new user

        $code = bin2hex(random_bytes(16)); // Generate a random code for the user


        // Prepare the data for insertion
        $data = [
            'id_restaurant' => $id_restaurant,
            'first_name' => $this->request->getPost('text_first_name'),
            'last_name'  => $this->request->getPost('text_last_name'),
            'full_name'  => $this->request->getPost('text_first_name') . ' ' . $this->request->getPost('text_last_name'),
            'email'      => $email,
            'phone'      => $phone,
            'username'   => $username,
            'roles'      => json_encode([$this->request->getPost('select_role')]),
            'is_active' => 0, // Set the user as active by default
            'code' => $code, // Store the generated code
            'created_at' => date('Y-m-d H:i:s'),

        ];

        // Insert the user into the database
        if ($users_model->insert($data)) {
            
            
        //sending email to user
        $this->_send_email($data);


            return redirect()->to('/users_management')->with('success', 'Usuário criado com sucesso.');

            //sending email to user
            
        } else {
            return redirect()->back()->withInput()->with('error', 'Erro ao criar usuário.');
        }
    }

    private function _send_email($data){

        //prepare purl -> personal url
        $data['purl'] = site_url('/auth/finish_registration/') .($data['code']);

        // config email

        $email = \Config\Services::email();
        $email->setFrom('noreply@cigburguer.com', 'Cig Burguer');
        $email->setTo($data['email']);
        $email->setSubject('Bem-vindo ao Cig Burguer - Complete seu cadastro');
        $email->setMailType('html');
        $email->setMessage(view('emails/email_finish_registration', $data));

        // Send the email and return the result
        return $email->send();

    }


    /**
     * Display the form to edit an existing user.
     *
     * @param string $enc_id The encrypted user ID.
     * @return string
     */

    public function edit($enc_id)
    {

        $id = Decrypt($enc_id);

        $users_model = new UsersManagementModel();
        $user = $users_model->find($id);

        if (!$user) {
            return redirect()->to('/users_management')->with('error', 'Usuário não encontrado.');
        }

        $data = [
            'title' => 'Editar Usuário',
            'page'  => 'Usuários',
            'user'  => $user,
        ];

        return view('dashboard/users_management/edit', $data);
    }

    /**
     * Handle the submission of the edit user form.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */

    private function _new_user_validation()
    {
        return [
            'text_first_name' => [
                'label' => 'Nome',
                'rules' => 'required|min_length[2]|max_length[50]',
                'errors' => [
                    'required'    => 'O {field} é obrigatório.',
                    'min_length'  => 'O {field} deve ter pelo menos {param} caracteres.',
                    'max_length'  => 'O {field} não pode ter mais de {param} caracteres.'
                ]
            ],
            'text_last_name'  => [
                'label' => 'Sobrenome',
                'rules' => 'required|min_length[2]|max_length[50]',
                'errors' => [
                    'required'    => 'O {field} é obrigatório.',
                    'min_length'  => 'O {field} deve ter pelo menos {param} caracteres.',
                    'max_length'  => 'O {field} não pode ter mais de {param} caracteres.'
                ]
            ],
            'text_email'      => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required'    => 'O {field} é obrigatório.',
                    'valid_email' => 'O {field} deve ser um email válido.',
                    'is_unique'   => 'O {field} já está em uso.'
                ]
            ],
            'text_phone'      => [
                'label' => 'Telefone',
                'rules' => 'required|regex_match[/^\+?[0-9\s\-\(\)]+$/]',
                'permit_empty|max_length[15]',
                'errors' => [
                    'required'    => 'O {field} é obrigatório.',
                    'regex_match' => 'O {field} deve conter apenas números, espaços, parênteses e traços.',
                    'max_length'  => 'O {field} não pode ter mais de {param} caracteres.',
                    'is_unique'   => 'O {field} já está em uso.'
                ]
            ],
            'text_username'   => [
                'label' => 'Usuário',
                'rules' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
                'errors' => [
                    'required'    => 'O {field} é obrigatório.',
                    'min_length'  => 'O {field} deve ter pelo menos {param} caracteres.',
                    'max_length'  => 'O {field} não pode ter mais de {param} caracteres.',
                    'is_unique'   => 'O {field} já está em uso.'
                ]
            ],
            'select_role' => [
                'label' => 'Perfil',
                'rules' => 'required|in_list[user,admin]',
                'errors' => [
                    'required'    => 'O {field} é obrigatório.',
                    'in_list'     => 'O {field} deve ser um dos seguintes: user, admin.'
                ]
            ]

        ];
    }
}
