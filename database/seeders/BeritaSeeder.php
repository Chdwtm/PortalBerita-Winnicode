<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user admin
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        // Pastikan ada kategori
        $kategori1 = Kategori::firstOrCreate(['nama' => 'Politik']);
        $kategori2 = Kategori::firstOrCreate(['nama' => 'Teknologi']);
        $kategori3 = Kategori::firstOrCreate(['nama' => 'Olahraga']);

        // Buat 20 berita dummy
        $kategoriList = [$kategori1, $kategori2, $kategori3];
        for ($i = 1; $i <= 20; $i++) {
            $kategori = $kategoriList[array_rand($kategoriList)];
            Berita::create([
                'judul' => "Berita Dummy ke-$i",
                'konten' => "Ini adalah konten berita dummy ke-$i. Berita ini dibuat secara otomatis untuk keperluan testing.",
                'kategori_id' => $kategori->id,
                'penulis_id' => $admin->id,
                'user_id' => $admin->id,
                'views' => rand(100, 1000),
            ]);
        }
    }
} 