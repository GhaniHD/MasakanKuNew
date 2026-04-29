<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        try {
            // Create admin user
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'), // Replace with desired password
                'role' => 'admin',
            ]);

            // Create regular user
            User::create([
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'), // Replace with desired password
                'role' => 'user',
            ]);
        } catch (\Exception $e) {
            // Log or display any errors that occur during seeding
            dd($e->getMessage());
        }
    }
}
