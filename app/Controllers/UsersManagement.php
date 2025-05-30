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
        $users = $users_model->findAll();
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

            ];
        }
        return $data;
    }
}
