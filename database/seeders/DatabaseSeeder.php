<?php
// database/seeders/DatabaseSeeder.php
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

        // Create Sample Armada
        $routes = [
            ['Jakarta', 'Bandung', 150000],
            ['Jakarta', 'Yogyakarta', 200000],
            ['Bandung', 'Surabaya', 300000],
            ['Jakarta', 'Semarang', 180000],
            ['Bandung', 'Jakarta', 150000],
        ];

        foreach ($routes as $index => $route) {
            Armada::create([
                'no_unik' => 'BUS' . sprintf('%03d', $index + 1),
                'id_rute' => $index + 1,
                'nama_armada' => 'Armada ' . ($index + 1),
                'kelas' => 'Ekonomi',
                'harga' => $route[2],
                'keterangan' => 'Armada ' . ($index + 1) . ' dari ' . $route[0] . ' ke ' . $route[1],
                'status' => 'available',
                'jadwal_keberangkatan' => now()->addDays($index)->format('Y-m-d H:i:s'),
                'jadwal_kedatangan' => now()->addDays($index + 1)->format('Y-m-d H:i:s'),
            ]);
        }
    }
}