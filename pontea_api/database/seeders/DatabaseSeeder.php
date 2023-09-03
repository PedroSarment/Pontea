<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersSeeder::class);
        $this->call(AreasSeeder::class);
        $this->call(LevelsSeeder::class);
        $this->call(AgeGroupsSeeder::class);
        $this->call(QuestionsSeeder::class);
        $this->call(CommentsSeeder::class);
        $this->call(PurchasesSeeder::class);
        $this->call(ActivitiesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(AuthsSeeder::class);
        $this->call(ShoppingCartSeeder::class);

    }
}
