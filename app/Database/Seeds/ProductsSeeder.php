<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        //create 6 products
        $products = [
            [
                'id_restaurant' =>  1,
                'name'          =>  'Hamburger',
                'description'   =>  'Descrição do melhor hamburguer do mundo',
                'category'      =>  'Hamburgueres',
                'price'         =>  '5.99',
                'promotion'     =>  0,
                'availability'   =>  1,
                'stock' =>  5000,
                'stock_min_limit' =>  100,
                'image'         =>  'burger_01.png',
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
            [
                'id_restaurant' =>  1,
                'name'          =>  'Cid Humburguer',
                'description'   =>  'Descrição do melhor hamburguer do mundo',
                'category'      =>  'Hamburgueres',
                'price'         =>  '15.99',
                'promotion'     =>  0,
                'availability'   =>  1,
                'stock' =>  10000,
                'stock_min_limit' =>  100,
                'image'         =>  'burger_02.png',
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
            [
                'id_restaurant' =>  1,
                'name'          =>  'Duble Humburguer',
                'description'   =>  'Descrição do melhor hamburguer do mundo',
                'category'      =>  'Hamburgueres',
                'price'         =>  '15.99',
                'promotion'     =>  0,
                'availability'   =>  1,
                'stock' =>  10000,
                'stock_min_limit' =>  100,
                'image'         =>  'burger_03.png',
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
            [
                'id_restaurant' =>  1,
                'name'          =>  'Suculento Humburguer',
                'description'   =>  'Descrição do melhor hamburguer do mundo',
                'category'      =>  'Hamburgueres',
                'price'         =>  '30.99',
                'promotion'     =>  0,
                'availability'   =>  1,
                'stock' =>  10000,
                'stock_min_limit' =>  100,
                'image'         =>  'burger_04.png',
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
            [
                'id_restaurant' =>  1,
                'name'          =>  'Duble Humburguer',
                'description'   =>  'Descrição do melhor hamburguer do mundo',
                'category'      =>  'Hamburgueres',
                'price'         =>  '28.99',
                'promotion'     =>  0,
                'availability'   =>  1,
                'stock' =>  50000,
                'stock_min_limit' =>  100,
                'image'         =>  'burger_05.png',
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
            [
                'id_restaurant' =>  1,
                'name'          =>  'Cig Humburguer',
                'description'   =>  'Descrição do melhor hamburguer do mundo',
                'category'      =>  'Hamburgueres',
                'price'         =>  '19.90',
                'promotion'     =>  0,
                'availability'   =>  1,
                'stock' =>  10000,
                'stock_min_limit' =>  100,
                'image'         =>  'burger_06.png',
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
            [
                'id_restaurant' =>  1,
                'name'          =>  'Drink',
                'description'   =>  'As melhores Bedidas do Mundo',
                'category'      =>  'Bebidas',
                'price'         =>  '19.90',
                'promotion'     =>  0,
                'availability'   =>  1,
                'stock' =>  2000,
                'stock_min_limit' =>  100,
                'image'         =>  'drink_1.png',
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
            [
                'id_restaurant' =>  1,
                'name'          =>  'Batata Francesa',
                'description'   =>  'A melhor batata do Mundo',
                'category'      =>  'Batatas',
                'price'         =>  '16.90',
                'promotion'     =>  0,
                'availability'   =>  1,
                'stock' =>  12000,
                'stock_min_limit' =>  100,
                'image'         =>  'french_fries.png',
                'created_at'    =>  date('Y-m-d H:i:s'),
            ],
            //... more products...

        ];

        //insert products data
        $this->db->table('products')->insertBatch($products);
    }
}
