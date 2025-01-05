<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class DBTest extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        try {
      
            // Atualizar para uma conexão segura
            $db->connect();
            
        } catch (DatabaseException $err) {
            echo('Erro de Conexao: ' . $err ->getMessage());
        }


    }
}
