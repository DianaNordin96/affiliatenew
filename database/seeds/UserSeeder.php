<?php

use Illuminate\Database\Seeder;
use App\Users;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Diana Nordin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'phone' => '0128475938',
            'address' => 'KL'
        ]);

        DB::table('users')->insert([
            'name' => 'Amir Khairuddin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'shogun',
            'phone' => '0128475938',
            'address' => 'KL'
        ]);
    }
}
