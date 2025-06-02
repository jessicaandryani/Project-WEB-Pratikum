<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Administrator Hotel Del Luna',
            'email' => 'admin@hoteldelluna.com',
            'phone' => '+62 21 1234 5678',
            'address' => 'Jl. Sudirman No. 1, Jakarta Pusat, DKI Jakarta',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Sample Regular Users
        $users = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'phone' => '+62 812 3456 7890',
                'address' => 'Jl. Kebon Jeruk No. 15, Jakarta Barat',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => true,
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'phone' => '+62 813 4567 8901',
                'address' => 'Jl. Cempaka Putih No. 22, Jakarta Pusat',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => true,
            ],
            [
                'name' => 'Ahmad Wijaya',
                'email' => 'ahmad@example.com',
                'phone' => '+62 814 5678 9012',
                'address' => 'Jl. Menteng Raya No. 8, Jakarta Pusat',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => true,
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'phone' => '+62 815 6789 0123',
                'address' => 'Jl. Kemang Raya No. 45, Jakarta Selatan',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => true,
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
