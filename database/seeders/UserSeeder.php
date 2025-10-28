<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->admin()
            ->create([
                'name' => 'Test User',
                'email' => 'user@gmail.com',
            ]);

        User::factory()
            ->librarian()
            ->create([
                'name' => 'Library Admin',
                'email' => 'lib@gmail.com',
            ]);

        User::factory()
            ->teacher()
            ->create([
                'name' => 'Teacher',
                'email' => 'teacher@gmail.com',
            ]);
    }
}
