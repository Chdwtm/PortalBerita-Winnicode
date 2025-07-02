<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\BeritaAnalytics;
use Illuminate\Database\Seeder;

class BeritaAnalyticsSeeder extends Seeder
{
    public function run()
    {
        // Get all beritas
        $beritas = Berita::all();

        foreach ($beritas as $berita) {
            // Create analytics data for each berita
            BeritaAnalytics::create([
                'berita_id' => $berita->id,
                'views' => rand(100, 1000),
                'avg_time_on_page' => rand(30, 300), // 30-300 seconds
                'bounce_rate' => rand(20, 80), // 20-80%
                'device' => ['desktop', 'mobile', 'tablet'][rand(0, 2)],
                'source' => ['direct', 'social', 'search', 'referral'][rand(0, 3)],
                'user_age_range' => ['18-24', '25-34', '35-44', '45-54', '55+'][rand(0, 4)]
            ]);
        }
    }
} 