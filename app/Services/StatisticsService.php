<?php

namespace App\Services;

use App\Models\Berita;
use App\Models\User;
use App\Models\Komentar;
use App\Models\Kategori;

class StatisticsService
{
    public function getDashboardStats()
    {
        return [
            'total_berita' => Berita::count(),
            'total_views' => Berita::sum('views'),
            'total_users' => User::count(),
            'total_komentar' => Komentar::count(),
            'total_kategori' => Kategori::count()
        ];
    }

    public function getBeritaStats()
    {
        return [
            'total_berita' => Berita::count(),
            'total_views' => Berita::sum('views'),
            'total_komentar' => Komentar::count(),
            'berita_per_kategori' => Kategori::withCount('beritas')->get()
        ];
    }

    public function getUserStats()
    {
        return [
            'total_users' => User::count(),
            'total_admin' => User::where('role', 'admin')->count(),
            'total_regular' => User::where('role', 'user')->count(),
            'users_with_content' => User::has('beritas')->count()
        ];
    }
} 