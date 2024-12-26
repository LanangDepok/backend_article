<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'user_id' => 1,
            'title' => 'Post Pertama',
            'description' => 'Ini adalah deskripsi post pertama'
        ]);
        Post::create([
            'user_id' => 1,
            'title' => 'Post Kedua',
            'description' => 'Ini adalah deskripsi post kedua'
        ]);
        Post::create([
            'user_id' => 2,
            'title' => 'Post Ketiga',
            'description' => 'Ini adalah deskripsi post ketiga'
        ]);
    }
}
