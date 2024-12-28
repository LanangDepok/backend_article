<?php

namespace Database\Seeders;

use App\Models\Biodata;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BiodataSeeder extends Seeder
{
   /**
    * Run the database seeds.
    */
   public function run(): void
   {
      Biodata::create([
         'user_id' => 1,
         'age' => 0,
         'gender' => 'Male'
      ]);
      Biodata::create([
         'user_id' => 2,
         'age' => 21,
         'gender' => 'Male'
      ]);
      Biodata::create([
         'user_id' => 3,
         'age' => 17,
         'gender' => 'Male'
      ]);
      Biodata::create([
         'user_id' => 4,
         'age' => 25,
         'gender' => 'Male'
      ]);
   }
}
