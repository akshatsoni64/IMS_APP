<?php

use Illuminate\Database\Seeder;

class StockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stocks')->insert([
            [
                'id' => '1',
                'cid' => 'C001',
                'pid' => 'P001',
                'quantity' => '10',
            ],
            [
                'id' => '2',
                'cid' => 'C002',
                'pid' => 'P001',
                'quantity' => '8',
            ]
        ]);
    }
}
