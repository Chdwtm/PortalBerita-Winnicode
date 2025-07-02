<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BeritaNasionalApiService
{
    private $baseUrl = "https://berita-indo-api-next.vercel.app/api/cnn-news/nasional";

    public function getBeritaNasional($limit = 10)
    {
        try {
            $response = Http::withOptions([
                'verify' => false, // Nonaktifkan SSL verification (jika masalah SSL)
                'curl' => [
                    CURLOPT_CONNECTTIMEOUT => 10, // Timeout koneksi
                    CURLOPT_TIMEOUT => 20, // Timeout total
                    CURLOPT_SSL_VERIFYPEER => false, // Nonaktifkan verifikasi SSL
                    CURLOPT_SSL_VERIFYHOST => false, // Nonaktifkan verifikasi host
                ]
            ])->timeout(20)->get($this->baseUrl);
            if ($response->successful()) {
                $data = $response->json();
                \Log::info('API Nasional Response', $data); // Log response untuk debug
                return array_slice($data['data'] ?? [], 0, $limit);
            }
            \Log::error('API Nasional gagal: ' . $response->status());
            return [];
        } catch (\Exception $e) {
            \Log::error('API Nasional Exception: ' . $e->getMessage());
            return [];
        }
    }
}