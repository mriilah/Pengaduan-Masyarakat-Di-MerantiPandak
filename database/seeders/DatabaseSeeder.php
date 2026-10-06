<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Masyarakat user for testing
        User::create([
            'name' => 'Masyarakat Test',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'role' => 'masyarakat',
            'email_verified_at' => now(),
        ]);

        // Default kategoris
        $kategoris = [
            ['nama' => 'Jalan', 'deskripsi' => 'Pengaduan terkait kondisi jalan'],
            ['nama' => 'Jembatan', 'deskripsi' => 'Pengaduan terkait kondisi jembatan'],
            ['nama' => 'Drainase', 'deskripsi' => 'Pengaduan terkait saluran air/drainase'],
            ['nama' => 'Lampu Jalan', 'deskripsi' => 'Pengaduan terkait penerangan jalan'],
            ['nama' => 'Sampah', 'deskripsi' => 'Pengaduan terkait pengelolaan sampah'],
            ['nama' => 'Fasilitas Umum', 'deskripsi' => 'Pengaduan terkait fasilitas umum lainnya'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
