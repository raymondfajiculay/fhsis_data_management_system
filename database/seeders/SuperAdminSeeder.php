<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Raymond',
            'last_name' => 'Fajiculay',
            'email' => 'admin@example.com', // Use your admin email
            'municipality' => 'NA',
            'password' => 'password', // Replace 'password' with a secure password
            'role' => 'super_admin', // Assuming you have a 'role' column in your 'users' table
        ]);
    }
}
