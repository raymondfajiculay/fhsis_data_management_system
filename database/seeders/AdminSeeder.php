<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'admin2@example.com',
            'municipality' => 'Sample Municipality',
            'password' => 'password',
            'role' => 'admin',
        ]);
    }
}
