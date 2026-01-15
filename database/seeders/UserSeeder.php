<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@arindama.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Main Staff',
            'email' => 'staff@arindama.com',
            'password' => Hash::make('12345678'),
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'Pak Jay',
            'email' => 'jay@arindama.com',
            'password' => Hash::make('12345678'),
            'role' => 'manager_it',
        ]);

        User::create([
            'name' => 'Mei Yung',
            'email' => 'mei@arindama.com',
            'password' => Hash::make('12345678'),
            'role' => 'gm',
        ]);
    }
}