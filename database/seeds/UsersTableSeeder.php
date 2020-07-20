<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'M0N573R Gas',
                'email' => 'monster@monster.com',
                'password' => '$2y$10$ilPGZp1tgk2zwEkoOUVeceh9qVvCQOp9WEkXanvzc7cT58BVr0/qC',
                'address' => 'AddressHere',
                'mobile' => '9123456789',
                'created_at' => date("Y-m-d"),
                'end_date' => date("Y-m-d"),
            ]
        ]);
    }
}
