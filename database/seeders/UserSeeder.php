<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario de prueba
        User::create([
            'name' => 'Usuario Demo',
            'email' => 'demo@promptvault.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);

        // Usuario admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@promptvault.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now()
        ]);
    }
}
