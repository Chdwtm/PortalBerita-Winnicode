<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\BeritaAnalytics;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataAnalyticsController extends Controller
{
    public function dashboard()
    {
        $analytics = [
            'sentiment_overview' => $this->getSentimentOverview(),
            'trending_topics' => $this->getTrendingTopics(),
            'popular_keywords' => $this->getPopularKeywords(),
            'engagement_metrics' => $this->getEngagementMetrics()
        ];

        return view('analytics.dashboard', compact('analytics'));
    }

    public function analyzeContent($berita_id)
    {
        $berita = Berita::findOrFail($berita_id);
        
        // Calculate basic metrics
        $analytics = [
            'sentiment_score' => $this->analyzeSentiment($berita->content),
            'keywords_extracted' => $this->extractKeywords($berita->content),
            'topic_classification' => $this->classifyTopic($berita->content),
            'reading_time' => $this->calculateReadingTime($berita->content),
            'popularity_score' => $this->calculatePopularityScore($berita_id)
        ];
        
        // Create or update analytics record
        BeritaAnalytics::updateOrCreate(
            ['berita_id' => $berita_id],
            $analytics
        );

        return response()->json(['message' => 'Analysis completed', 'data' => $analytics]);
    }

    private function analyzeSentiment($content)
    {
        // Implement sentiment analysis logic here
        // For now, return a random score between -1 and 1
        return rand(-100, 100) / 100;
    }

    private function extractKeywords($content)
    {
        // Basic keyword extraction (implement more sophisticated logic later)
        $words = str_word_count(strip_tags($content), 1);
        $wordCount = array_count_values($words);
        arsort($wordCount);
        
        return array_slice(array_keys($wordCount), 0, 10);
    }

    private function classifyTopic($content)
    {
        // Implement topic classification logic here
        $topics = ['Technology', 'Politics', 'Business', 'Entertainment', 'Sports'];
        return $topics[array_rand($topics)];
    }

    private function calculateReadingTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        // Average reading speed: 200 words per minute
        return ceil($wordCount / 200 * 60);
    }

    private function calculatePopularityScore($berita_id)
    {
        // Calculate based on views, comments, and reactions
        $metrics = DB::table('berita_reactions')
            ->where('berita_id', $berita_id)
            ->selectRaw('COUNT(*) as total_reactions')
            ->first();
            
        $comments = Komentar::where('berita_id', $berita_id)->count();
        
        return ($metrics->total_reactions + $comments) / 10;
    }

    private function getSentimentOverview()
    {
        return BeritaAnalytics::select(
            DB::raw('
                COUNT(CASE WHEN sentiment_score > 0 THEN 1 END) as positive,
                COUNT(CASE WHEN sentiment_score < 0 THEN 1 END) as negative,
                COUNT(CASE WHEN sentiment_score = 0 THEN 1 END) as neutral
            ')
        )->first();
    }

    private function getTrendingTopics()
    {
        return BeritaAnalytics::select('topic_classification')
            ->groupBy('topic_classification')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(5)
            ->get();
    }

    private function getPopularKeywords()
    {
        return BeritaAnalytics::select('keywords_extracted')
            ->whereNotNull('keywords_extracted')
            ->limit(50)
            ->get()
            ->pluck('keywords_extracted')
            ->flatten()
            ->countBy()
            ->sortDesc()
            ->take(10);
    }

    private function getEngagementMetrics()
    {
        return BeritaAnalytics::select(
            DB::raw('
                AVG(engagement_score) as avg_engagement,
                AVG(reading_time) as avg_reading_time,
                AVG(popularity_score) as avg_popularity,
                AVG(click_through_rate) as avg_ctr,
                AVG(bounce_rate) as avg_bounce_rate
            ')
        )->first();
    }
} 