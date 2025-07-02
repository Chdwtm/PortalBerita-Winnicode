<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\BeritaAnalytics;
use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Get total articles and growth
        $totalArticles = Berita::count();
        $lastMonthArticles = Berita::where('created_at', '<=', Carbon::now()->subMonth())->count();
        $articleGrowth = $lastMonthArticles > 0 
            ? round((($totalArticles - $lastMonthArticles) / $lastMonthArticles) * 100, 1)
            : 0;

        // Get total views and growth
        $totalViews = BeritaAnalytics::sum('views');
        $lastMonthViews = BeritaAnalytics::where('created_at', '<=', Carbon::now()->subMonth())->sum('views');
        $viewsGrowth = $lastMonthViews > 0 
            ? round((($totalViews - $lastMonthViews) / $lastMonthViews) * 100, 1)
            : 0;

        // Get average time on page
        $avgTimeOnPage = BeritaAnalytics::avg('avg_time_on_page');
        $lastMonthAvgTime = BeritaAnalytics::where('created_at', '<=', Carbon::now()->subMonth())->avg('avg_time_on_page');
        $timeOnPageChange = $lastMonthAvgTime > 0 
            ? round((($avgTimeOnPage - $lastMonthAvgTime) / $lastMonthAvgTime) * 100, 1)
            : 0;

        // Get bounce rate
        $bounceRate = BeritaAnalytics::avg('bounce_rate');
        $lastMonthBounceRate = BeritaAnalytics::where('created_at', '<=', Carbon::now()->subMonth())->avg('bounce_rate');
        $bounceRateChange = $lastMonthBounceRate > 0 
            ? round((($bounceRate - $lastMonthBounceRate) / $lastMonthBounceRate) * 100, 1)
            : 0;

        // Get traffic data for the last 7 days
        $trafficData = BeritaAnalytics::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(views) as total_views')
        )
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->limit(7)
            ->get()
            ->reverse();

        $trafficLabels = $trafficData->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('M d');
        });
        $trafficValues = $trafficData->pluck('total_views');

        // Get category data
        $categoryData = Kategori::withCount(['beritas' => function($query) {
            $query->has('analytics');
        }])->get();
        $categoryLabels = $categoryData->pluck('nama');
        $categoryValues = $categoryData->pluck('beritas_count');

        // Get device distribution
        $deviceData = [
            BeritaAnalytics::where('device', 'desktop')->count(),
            BeritaAnalytics::where('device', 'mobile')->count(),
            BeritaAnalytics::where('device', 'tablet')->count(),
        ];

        // Get traffic sources
        $sourceData = [
            BeritaAnalytics::where('source', 'direct')->count(),
            BeritaAnalytics::where('source', 'social')->count(),
            BeritaAnalytics::where('source', 'search')->count(),
            BeritaAnalytics::where('source', 'referral')->count(),
        ];

        // Get top performing articles
        $topArticles = Berita::with(['analytics', 'kategori'])
            ->join('berita_analytics', 'beritas.id', '=', 'berita_analytics.berita_id')
            ->orderBy('berita_analytics.views', 'DESC')
            ->select('beritas.*', 'berita_analytics.views', 'berita_analytics.avg_time_on_page', 'berita_analytics.bounce_rate')
            ->limit(5)
            ->get();

        // Get demographics data (simulated for now)
        $demographicsData = [15, 30, 25, 20, 10];

        return view('admin.analytics.index', compact(
            'totalArticles',
            'articleGrowth',
            'totalViews',
            'viewsGrowth',
            'avgTimeOnPage',
            'timeOnPageChange',
            'bounceRate',
            'bounceRateChange',
            'trafficLabels',
            'trafficValues',
            'categoryLabels',
            'categoryValues',
            'deviceData',
            'sourceData',
            'topArticles',
            'demographicsData'
        ));
    }
} 