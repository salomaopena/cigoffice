<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['last_login'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    //protected $lastLoginField = 'last_login';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function check_for_login($email, $password, $restaurant_id)
    {
        //where clauses
        $where = [
            'email' => $email,
            'id_restaurant' => $restaurant_id,
            //'username' => $email,
            'is_active' => 1, //User must be active
            'blocked_until' => null, //User must be an administrator
            'deleted_at ' => null //User must not be deleted
            //add more conditions as needed
        ];

        $user = $this->where($where)->first();
        //$user = $this->orWhere()->first();
        //if user does not exist or password is incorrect, return false
        if (empty($user)) {
            return false;
        }

        if (!password_verify($password, $user->passwrd)) {
            return false;
        }
        //User found, update last login date

        $this->update($user->id, ['last_login' => date('Y-m-d H:i:s')]);

        //return the user object
        return $user;
    }
}
