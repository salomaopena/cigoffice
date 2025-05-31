<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RestaurantModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function login()
    {
        //Load restaurant data
        $restaurant_model = new RestaurantModel();
        $restaurants = $restaurant_model->select('id, name')->findAll();
        //Pass restaurant data to the view
        $data['restaurants'] = $restaurants;


        //validation errors
        //Pass validation errors to the view
        $data['validation_errors'] = session()->getFlashdata('validation_errors');
        $data['restaurant_selected'] = session()->getFlashdata('restaurant_selected');

        //Pass login error to the view
        $data['login_error'] = session()->getFlashdata('login_error');

        //Load the login form view
        return view('auth/login-form', $data);
    }

    public function login_submit()
    {

        //validation 
        $validation = $this->validate([
            'restaurant_selected' => [
                'label' => 'Restaurante',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Selecione um {field} válido.'
                ]
            ],
            'email' => [
                'label' =>  'Email',
                'rules' => 'required|valid_email|max_length[254]',
                'errors' => [
                    'required' => 'Preencha o campo {field}.',
                    'valid_email' => 'Preencha um {field} válido.',
                    'max_length' => 'O campo {field} não pode exceder {param} caracteres.'
                ]
            ],
            'password' => [
                'label' =>  'Senha',
                'rules' => 'required|min_length[5]|max_length[255]|alpha_numeric_punct',
                'errors' => [
                    'required' => 'Preencha o campo {field}.',
                    'min_length' => 'O campop {field} deve ter pelo menos {param} caracteres.',
                    'max_length' => 'O campo {field} não pode exceder {param} caracteres.',
                    'alpha_numeric_punct' => 'A {field} deve conter letras e caracteres especiais.'
                ]
            ],
        ]);

        if (!$validation) {
            session()->setFlashdata('restaurant_selected', Decrypt($this->request->getPost('restaurant_selected')));
            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $restaurant_id = Decrypt($this->request->getPost('restaurant_selected'));

        //check if user exists and password is correct
        $user_model = new UserModel();
        $user = $user_model->check_for_login($email, $password, $restaurant_id);

        //if user exists and password is correct, log them in
        if (!$user) {
            session()->setFlashdata('restaurant_selected', Decrypt($this->request->getPost('restaurant_selected')));
            return redirect()->back()->withInput()->with('login_error', 'Utilizador e/ou senha inválidos.');
        }

        //set session
        $restaurant =  new RestaurantModel();
        $restaurant_name = $restaurant->select('name')->find($user->id_restaurant)->name;

        $user_data = [
            'id' => $user->id,
            'id_restaurant' => $user->id_restaurant,
            'restaurant_name' => $restaurant_name,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'roles' => $user->roles
        ];

        session()->set('user', $user_data);

        return redirect()->to('/');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }

    public function finish_registration($pul_code = null)
    {


        if (empty($pul_code)) {
            return redirect()->to('/auth/login');
        }


        //Load the user model

        $user_model = new UserModel();

        // get information from url incluiding the user id and the code

        $user_info = $user_model->select('users.*, restaurants.name as restaurant_name')
            ->where('users.code', $pul_code)
            ->join('restaurants', 'restaurants.id = users.id_restaurant')
            ->first();
        //Load the finish registration view


        if (empty($user_info)) {
            return redirect()->to('/auth/login');
        }

        $new_user_data = [
            'id' => $user_info->id,
            'restaurant_name' => $user_info->restaurant_name,
            'id_restaurant' => $user_info->id_restaurant,
            'first_name' => $user_info->first_name,
            'last_name' => $user_info->last_name,
            'email' => $user_info->email,
            'phone' => $user_info->phone,
            'username' => $user_info->username,
            'roles' => json_decode($user_info->roles, true),
        ];

        session()->set('new_user', $new_user_data);



        return redirect()->to('auth/define_password');
    }

    public function define_password()
    {
        //Check if the user is already logged in
        if (!session()->has('new_user')) {
            return redirect()->to('/auth/login');
        }
        //Load the validation errors and server error messages
        $data = [
            'validation_errors' => session()->getFlashdata('validation_errors'),
            'server_error' => session()->getFlashdata('server_error'),
        ];

        return view('auth/define_password', $data);
    }

    public function define_password_submit(){
        //Check if the user is already logged in
        if (!session()->has('new_user')) {
            return redirect()->to('/auth/login');
        }

        //Validate the password
        $validation = $this->validate($this->_define_new_password_validation_rules());

        if (!$validation) {
            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }

        //Get the new user data from session
        $new_user = session()->get('new_user');

        //Update the user password
        $user_model = new UserModel();
        $id_user = $new_user['id'];
        $password = $this->request->getPost('text_password');

        $user_model->update($id_user, [
            'passwrd' => password_hash($password, PASSWORD_DEFAULT),
            'code' => null, // Clear the code after setting the password
            'is_active' => 1, // Set the user as active
            'blocked_until' => null, // Clear any block status
            'updated_at' => date('Y-m-d H:i:s'), // Update the timestamp
        ]);

        //Remove the new user data from session
        session()->remove('new_user');

        return redirect()->to('/auth/welcome')->with('success',true);
    }


    public function welcome()
    {
        if(!session()->getFlashdata('success')){
            return redirect()->to('/auth/login');
        }

        //Load the welcome view
        return view('auth/welcome');
    }

    private function _define_new_password_validation_rules()
    {
        return [
            'password' => [
                'label' => 'Senha',
                'rules' => 'required|min_length[8]|max_length[16]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => [
                    'required' => 'Preencha o campo {field}.',
                    'min_length' => 'A {field} deve ter pelo menos {param} caracteres.',
                    'max_length' => 'A {field} não pode exceder {param} caracteres.',
                    'regex_match' => 'A {field} deve conter pelo menos uma letra maiúscula, uma minúscula e um algarismo.'
                ]
            ],
            'password_confirm' => [
                'label' => 'Confirmação da Senha',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Preencha o campo {field}.',
                    'matches' => 'A {field} deve ser igual à Senha.'
                ]
            ],
        ];
    }
}
