<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'bagas@gmail.com',
            'name' => 'Bagas',
            'password' => '123'
        ]);
        User::create([
            'email' => 'rizki@gmail.com',
            'name' => 'Rizki',
            'password' => '123'
        ]);
        User::create([
            'email' => 'yanto@gmail.com',
            'name' => 'Yanto',
            'password' => '123'
        ]);
    }
}
