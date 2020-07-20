<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'id' => 'P001',
                'name' => 'LPG 7KG Cylinder',
                'quantity' => '10',
                'active' => '1',
                'created_at' => date("Y-m-d"),
            ],[
                'id' => 'P002',
                'name' => 'LPG 15KG Cylinder',
                'quantity' => '10',
                'active' => '1',
                'created_at' => date("Y-m-d"),
            ],
        ]);
    }
}
