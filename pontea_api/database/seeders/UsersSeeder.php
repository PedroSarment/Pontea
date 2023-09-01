<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // You can customize the default password
            'profession' => 'Admin',
            'photo_path' => null, // Customize as needed
            'is_teacher' => true, // Customize the admin user type
            'credit' => 1000.00, // Customize the credit amount
            'created_at' => now(),
            'updated_at' => now(),
        ]); */

        // Generate additional users using the factory
        User::factory(20)->create();
    }
}
