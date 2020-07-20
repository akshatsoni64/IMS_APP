<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            [
                'name' => 'Name1',
                'org_name' => 'The quick brown fox jumps over the lazy dog',
                'email' => 'email1@email.com',
                'address' => 'address',
                'mobile' => '9123456789',
                'active' => '1',
                'created_at' => date("Y-m-d"),
            ],[
                'name' => 'Name2',
                'org_name' => 'The quick brown fox jumps over the lazy dog',
                'email' => 'email2@email.com',
                'address' => 'address',
                'mobile' => '9123456789',
                'active' => '1',
                'created_at' => date("Y-m-d"),
            ],
        ]);
    }
}
