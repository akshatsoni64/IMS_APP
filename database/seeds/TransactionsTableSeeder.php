<?php

use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactions')->insert([
            [
                'pid' => 'P001',
                'cid' => 'C001',
                'issue' => '10',
                'receive' => '5',
                'vehicle_number' => 'GJ01MT0022',
                't_date' => date("Y-m-d"),
            ],[
                'pid' => 'P002',
                'cid' => 'C002',
                'issue' => '10',
                'receive' => '5',
                'vehicle_number' => 'GJ01MT0202',
                't_date' => date("Y-m-d"),
            ],
        ]);
    }
}
