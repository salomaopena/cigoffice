<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RestaurantModel;

class Main extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'page' => 'dashboard',
        ];

        $restaurantModel = new RestaurantModel();
        $id_restaurant = session()->user['id_restaurant'];;
        $data['restaurant'] = $restaurantModel->find($id_restaurant);

        return view('dashboard/home', $data);
    }

    public function noAccessAllowed()
    {
        $data = [
            'title' => 'Acesso Negado',
            'page' => '',
            'error' => 'Você não tem permissão para acessar esta página. Por favor, entre em contato com o administrador do sistema se você acredita que isso é um erro.',
        ];

        return view('errors/no_access_allowed', $data);
    }
}
