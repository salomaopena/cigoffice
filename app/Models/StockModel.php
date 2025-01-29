<?php

namespace App\Models;

use CodeIgniter\Model;

class StockModel extends Model
{
    protected $table            = 'stocks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_product',
        'stock_quantity',
        'stock_in_out',
        'stock_supplier',
        'reason',
        'created_at',
        'updated_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
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

    public function get_stock_supplier($id_restaurant){
        //get suppliers whi
        //where id_restaurant is $id_restaurant
        //and stock_in_out is 'Entrada de Stock'
        //and stock_quantity > 0
        //order by stock_quantity DESC
        //limit 10
        $builder = $this->db->table('stocks')
                ->distinct()
                ->select('stocks.stock_supplier')
                ->join('products','products.id=stocks.id_product')
                ->where('products.id_restaurant',$id_restaurant)
                ->where('stocks.stock_in_out','IN');
        $query = $builder->get();
        return $query->getResult();
    }
}

