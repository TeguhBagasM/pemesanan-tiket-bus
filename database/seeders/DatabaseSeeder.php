<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Armada;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Owner
        User::create([
            'name' => 'Owner',
            'email' => 'owner@example.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        // Create Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'jabatan' => 'Administrator',
            'email_verified_at' => now(),
        ]);

        // Create User
        User::create([
            'name' => 'User Test',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'no_telepon' => '081234567890',
            'email_verified_at' => now(),
        ]);

        // Sample data armada
        $routes = [
            ['Jakarta', 'Bandung', 150000, '08:00:00'],
            ['Jakarta', 'Yogyakarta', 200000, '09:00:00'],
            ['Bandung', 'Surabaya', 300000, '07:30:00'],
            ['Jakarta', 'Semarang', 180000, '10:15:00'],
            ['Bandung', 'Jakarta', 150000, '06:45:00'],
        ];

        foreach ($routes as $index => $route) {
            Armada::create([
                'no_unik' => 'BUS' . sprintf('%03d', $index + 1),
                'id_admin' => $admin->id,
                'supir' => 'Supir ' . ($index + 1),
                'jumlah_kursi' => 40,
                'no_kendaraan' => 'D' . rand(1000, 9999) . 'AB',
                'rute_asal' => $route[0],
                'rute_tujuan' => $route[1],
                'harga_tiket' => $route[2],
                'jam_berangkat' => $route[3],
            ]);
        }
    }
}
