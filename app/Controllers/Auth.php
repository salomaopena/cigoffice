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

    public function define_password_submit()
    {
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

        return redirect()->to('/auth/welcome')->with('success', true);
    }


    public function welcome()
    {
        if (!session()->getFlashdata('success')) {
            return redirect()->to('/auth/login');
        }

        //Load the welcome view
        return view('auth/welcome');
    }

    // Profile page
    public function profile()
    {

        //Check if the user is logged in
        if (!session()->has('user')) {
            return redirect()->to('/auth/login');
        }

        //Load the user model
        $user_model = new UserModel();
        //Get the user data from session
        $user = $user_model->find(session()->user['id']);
        $user->roles = json_decode($user->roles, true)[0];

        //Check if the user exists
        if (!$user) {
            return redirect()->to('/auth/login');
        }


        //Load the validation errors and server error messages
        $data = [
            'title' => 'Perfil',
            'page' => 'Perfil',
            'user' => $user,
            'validation_errors' => session()->getFlashdata('validation_errors'),
            'server_error' => session()->getFlashdata('server_error'),
            'profile_success' => session()->getFlashdata('profile_success'),
            'profile_change_password_success' => session()->getFlashdata('profile_change_password_success'),

        ];

        return view('auth/profile', $data);
    }

    //Profile form submit
    public function profile_submit()
    {
        //form validation

        $validation =  $this->validate($this->_profile_form_validation_rules());

        if (!$validation) {
            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }

        // update user data
        $user_model = new UserModel();
        $user_id = session()->user['id'];

        //check if there is another email exists
        $other_user = $user_model->where('email', $this->request->getPost('text_email'))
            ->where('id !=', $user_id)
            ->get()->getResultArray();

        if (!empty($other_user)) {
            return redirect()->back()->withInput()->with('server_error', 'Já existe um utilizador com este e-mail.');
        }

        $user_data = [
            'first_name' => $this->request->getPost('text_first_name'),
            'last_name' => $this->request->getPost('text_last_name'),
            'email' => $this->request->getPost('text_email'),
            'phone' => $this->request->getPost('text_phone'),
            'updated_at' => date('Y-m-d H:i:s'), // Update the timestamp
        ];

        $user_model->update($user_id, $user_data);

        $user = session()->user;
        $user['last_name'] = $this->request->getPost('text_last_name');
        $user['first_name'] = $this->request->getPost('text_first_name');
        $user['email'] = $this->request->getPost('text_email');
        $user['phone'] = $this->request->getPost('text_phone');
        session()->set('user', $user);
        //Redirect to profile page with success message
        return redirect()->to(site_url('/auth/profile'))->with('profile_success', 'Perfil atualizado com sucesso!');
    }

    //Profile form validation rules
    private function _profile_form_validation_rules()
    {
        return [
            'text_first_name' => [
                'label' => 'Nome',
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => 'Preencha o campo {field}.',
                    'max_length' => 'O campo {field} não pode exceder {param} caracteres.'
                ]
            ],
            'text_last_name' => [
                'label' => 'Sobrenome',
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => 'Preencha o campo {field}.',
                    'max_length' => 'O campo {field} não pode exceder {param} caracteres.'
                ]
            ],
            'text_email' => [
                'label' =>  'E-mail',
                'rules' => 'required|valid_email|max_length[254]',
                'errors' => [
                    'required' => 'Preencha o campo {field}.',
                    'valid_email' => 'Preencha um {field} válido.',
                    'max_length' => 'O campo {field} não pode exceder {param} caracteres.'
                ]
            ],
            'text_phone' => [
                'label' =>  'Telefone',
                'rules' => 'required|max_length[20]',
                'errors' => [
                    'required' => 'Preencha o campo {field}.',
                    'max_length' => '{field} não pode exceder {param} caracteres.'
                ]
            ],
        ];
    }

    // Change password form submit
    public function change_password_submit()
    {
        //form validation

        $validation = $this->validate($this->_profile_change_password_validation_rules());

        if (!$validation) {
            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }

        //check if the current password is correct
        $user_model = new UserModel();
        $user_id = session()->user['id'];
        $user = $user_model->find($user_id);

        $password = $this->request->getPost('text_password');

        if (!password_verify($password, $user->passwrd)) {
            return redirect()->back()->withInput()->with('validation_errors', ['text_password' => 'Senha atual incorreta.']);
        }

        //Update the user password
        $new_password = $this->request->getPost('text_new_password');
        $user_model->update($user_id, [
            'passwrd' => password_hash($new_password, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s'), // Update the timestamp
        ]);

        //Redirect to profile page with success message
        return redirect()->to(site_url('/auth/profile'))->with('profile_change_password_success', 'Senha alterada com sucesso!');
    }


    //forgot password form validation rules
    public function forgot_password()
    {
        //Load the validation errors and server error messages
        // Loard Restaurant data

        $restaurant_model = new RestaurantModel();
        $restaurants = $restaurant_model->select('id, name')->findAll();
        //Pass restaurant data to the view

        $data['restaurants'] = $restaurants;
        $data['title'] = 'Esqueci minha senha';
        //Pass validation errors and server error messages to the view
        $data['validation_errors'] = session()->getFlashdata('validation_errors');
        $data['server_error'] = session()->getFlashdata('server_error');

        //Pass restaurant selected to the view

        return view('auth/forgot_password', $data);
    }

    //forgot password submit
    public function forgot_password_submit()
    {
        //Validate the form
        $validation = $this->validate($this->_forgot_password_validation_rules());

        if (!$validation) {
            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }

        // check if email exists in the database
        $restaurant_id = Decrypt($this->request->getPost('select_restaurant'));
        $email = $this->request->getPost('text_email');

        if (empty($restaurant_id)) {
            return redirect()->back()->withInput()->with('validation_errors', ['select_restaurant' => 'Selecione um restaurante válido.']);
        }

        $user_model = new UserModel();
        $user = $user_model->where('email', $email)
            ->where('id_restaurant', $restaurant_id)
            ->first();

        // Always show success to avoid revealing if the email exists or not

        if (!$user) {
            $this->_show_forgot_password_success();
        }


        // Generate a unique code for password reset
        $code = bin2hex(random_bytes(16));
        // Update the user with the code and set them as inactive
        $user_model->update($user->id, [
            'code' => $code,
            'updated_at' => date('Y-m-d H:i:s'), // Update the timestamp
        ]);

        $data = [
            'id' => $user->id,
            'code' => $code,
            'full_name' => $user->first_name . ' ' . $user->last_name,
            'email' => $email,
        ];

        // Send the email with the reset link
        $this->_send_forgot_password_email($data);

        // Show success message
        $this->_show_forgot_password_success();
    }

    // Reset password form
    public function reset_password($purl_code = null)
    {
        //Check if the code is valid
        if (empty($purl_code)) {
            return redirect()->to('/auth/login');
        }

        //Load the user model
        $user_model = new UserModel();
        $user = $user_model->where('code', $purl_code)->first();

        //Check if the user exists
        if (!$user) {
            return redirect()->to('/auth/login');
        }

        //Load the reset password view
        $data = [
            'code' => $purl_code,
            'validation_errors' => session()->getFlashdata('validation_errors'),
            'server_error' => session()->getFlashdata('server_error'),
        ];

        return view('auth/redefine_password', $data);
    }

    // Reset password submit
    public function reset_password_submit()
    {
        //Validate the form
        $validation = $this->validate($this->_reset_password_validation_rules());

        if (!$validation) {
            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }

        //Get the code from the form
        $purl_code = $this->request->getPost('purl_code');
        $new_password = $this->request->getPost('text_password');

        //Load the user model
        $user_model = new UserModel();
        $user = $user_model->where('code', $purl_code)->first();

        //Check if the user exists
        if (!$user) {
            return redirect()->to('/auth/login');
        }


        $user_model->update($user->id, [
            'passwrd' => password_hash($new_password, PASSWORD_DEFAULT),
            'code' => null, // Clear the code after setting the password
            'updated_at' => date('Y-m-d H:i:s'), // Update the timestamp
        ]);

        //Redirect to login page with success message
        return view('auth/reset_password_success', [
            'success_message' => 'Senha redefinida com sucesso! Você pode fazer login agora.'
        ]);
    }

    // send forgot password email
    private function _send_forgot_password_email($data)
    {
        // Get the data from the session
        $data['purl'] = site_url('auth/reset_password/' . $data['code']);

        // Load the email library

        // config email

        $email = \Config\Services::email();
        $email->setFrom('noreply@cigburguer.com', 'Cig Burguer');
        $email->setTo($data['email']);
        $email->setSubject('Bem-vindo ao Cig Burguer - Recuperação de email');
        $email->setMailType('html');
        $email->setMessage(view('emails/email_recover_registration', $data));

        // Send the email and return the result
        return $email->send();
    }

    // Show success message after forgot password
    private function _show_forgot_password_success()
    {
        echo view('/auth/forgot_password_success');
    }

    private function _forgot_password_validation_rules()
    {
        return [
            'select_restaurant' => [
                'label' => 'Restaurante',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Selecione um {field} válido.'
                ]
            ],
            'text_email' => [
                'label' =>  'E-mail',
                'rules' => 'required|valid_email|max_length[254]',
                'errors' => [
                    'required' => 'Preencha o campo {field}.',
                    'valid_email' => 'Preencha um {field} válido.',
                    'max_length' => 'O campo {field} não pode exceder {param} caracteres.'
                ]
            ],
        ];
    }

    //Change password validation rules
    private function _profile_change_password_validation_rules()
    {
        return [
            'text_password' => [
                'label' => 'Senha Atual',
                'rules' => 'required|min_length[8]|max_length[16]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => [
                    'required' => 'Preencha o campo {field}.',
                    'min_length' => 'A {field} deve ter pelo menos {param} caracteres.',
                    'max_length' => 'A {field} não pode exceder {param} caracteres.',
                    'regex_match' => 'A {field} deve conter pelo menos uma letra maiúscula, uma minúscula e um algarismo.'
                ]
            ],
            'text_new_password' => [
                'label' => 'Nova Senha',
                'rules' => 'required|min_length[8]|max_length[16]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => [
                    'required' => 'Preencha o campo {field}.',
                    'min_length' => 'A {field} deve ter pelo menos {param} caracteres.',
                    'max_length' => 'A {field} não pode exceder {param} caracteres.',
                    'regex_match' => 'A {field} deve conter pelo menos uma letra maiúscula, uma minúscula e um algarismo.'
                ]
            ],
            'text_new_password_confirm' => [
                'label' =>  'Confirmação da Senha',
                'rules' =>  'required|matches[text_new_password]',
                'errors' => [
                    'required' =>  '{field} é obrigatório.',
                    'matches' =>  '{field} deve ser igual à Nova Senha.'
                ]
            ],
        ];
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


    private function _reset_password_validation_rules()
    {
        return [
            'purl_code' => [
                'label' => '',
                'rules' => 'required|alpha_numeric',
                'errors' => [
                    'required' => 'Aconteceu um erro, tente novamente.',
                ]
            ],
            'text_password' => [
                'label' => 'Senha',
                'rules' => 'required|min_length[8]|max_length[16]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => [
                    'required' => 'Preencha o campo {field}.',
                    'min_length' => 'A {field} deve ter pelo menos {param} caracteres.',
                    'max_length' => 'A {field} não pode exceder {param} caracteres.',
                    'regex_match' => 'A {field} deve conter pelo menos uma letra maiúscula, uma minúscula e um algarismo.'
                ]
            ],
            'text_password_confirm' => [
                'label' => 'Confirmação da Senha',
                'rules' => 'required|matches[text_password]',
                'errors' => [
                    'required' => 'Preencha o campo {field}.',
                    'matches' => 'A {field} deve ser igual à Senha.'
                ]
            ],
        ];
    }
}
