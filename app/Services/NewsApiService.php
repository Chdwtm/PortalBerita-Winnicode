<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class NewsApiService
{
    private $apiKey;
    private $baseUrl = "https://newsapi.org/v2/top-headlines";

    public function __construct()
    {
        $this->apiKey = config('services.newsapi.key');
    }

    public function getTopHeadlines($language = 'en', $limit = 10)
    {
        return Cache::remember('news_api_headlines', 3600, function () use ($language, $limit) {
            try {
                $response = Http::timeout(5)
                    ->get($this->baseUrl, [
                        'language' => $language,
                        'apiKey' => $this->apiKey
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return array_slice($data['articles'] ?? [], 0, $limit);
                }
                
                return [];
            } catch (\Exception $e) {
                report($e);
                return [];
            }
        });
    }
} 