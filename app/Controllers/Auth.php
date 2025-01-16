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
        $user = $user_model->check_for_login($email,$password, $restaurant_id);

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

        session()->set('user',$user_data);

        return redirect()->to('/');

    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
