<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Gere comentários usando o factory
        Comment::factory(50)->create();
    }
}
