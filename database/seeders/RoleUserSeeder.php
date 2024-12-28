<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_user')->insert([
            ['role_id' => 1, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'user_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'user_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 3, 'user_id' => 4, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
