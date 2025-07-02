@extends('layouts.admin')

@section('title', 'Analytics Dashboard')

@section('breadcrumbs')
<nav class="text-sm text-gray-500 mb-4" aria-label="Breadcrumb">
    <ol class="list-none p-0 inline-flex">
        <li class="flex items-center">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-red-600">
                <i class="fas fa-home"></i>
            </a>
            <span class="mx-2">/</span>
        </li>
        <li class="flex items-center">
            Analytics
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container mx-auto px-4">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">News Analytics Dashboard</h1>
        <p class="text-gray-600 mt-2">Track and analyze news performance and engagement metrics</p>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Articles -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Articles</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $totalArticles ?? 0 }}</h3>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-newspaper text-blue-600"></i>
                </div>
            </div>
            <p class="text-green-600 text-sm mt-4">
                <i class="fas fa-arrow-up"></i>
                <span class="ml-1">{{ $articleGrowth ?? '0%' }} from last month</span>
            </p>
        </div>

        <!-- Total Views -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Views</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $totalViews ?? 0 }}</h3>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-eye text-green-600"></i>
                </div>
            </div>
            <p class="text-green-600 text-sm mt-4">
                <i class="fas fa-arrow-up"></i>
                <span class="ml-1">{{ $viewsGrowth ?? '0%' }} from last month</span>
            </p>
        </div>

        <!-- Average Time on Page -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Avg. Time on Page</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $avgTimeOnPage ?? '0:00' }}</h3>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-clock text-purple-600"></i>
                </div>
            </div>
            <p class="text-purple-600 text-sm mt-4">
                <i class="fas fa-arrows-left-right"></i>
                <span class="ml-1">{{ $timeOnPageChange ?? '0%' }} vs last month</span>
            </p>
        </div>

        <!-- Bounce Rate -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Bounce Rate</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $bounceRate ?? '0%' }}</h3>
                </div>
                <div class="bg-red-100 rounded-full p-3">
                    <i class="fas fa-chart-simple text-red-600"></i>
                </div>
            </div>
            <p class="text-red-600 text-sm mt-4">
                <i class="fas fa-arrow-down"></i>
                <span class="ml-1">{{ $bounceRateChange ?? '0%' }} from last month</span>
            </p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Traffic Overview -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Traffic Overview</h3>
            <div class="h-80">
                <!-- Add your chart here -->
                <canvas id="trafficChart"></canvas>
            </div>
        </div>

        <!-- Popular Categories -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Popular Categories</h3>
            <div class="h-80">
                <!-- Add your chart here -->
                <canvas id="categoriesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Articles Table -->
    <div class="bg-white rounded-lg shadow-sm mb-8">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Performing Articles</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b border-gray-200">
                            <th class="pb-3 font-semibold text-gray-600">Title</th>
                            <th class="pb-3 font-semibold text-gray-600">Views</th>
                            <th class="pb-3 font-semibold text-gray-600">Avg. Time</th>
                            <th class="pb-3 font-semibold text-gray-600">Bounce Rate</th>
                            <th class="pb-3 font-semibold text-gray-600">Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topArticles as $article)
                        <tr class="border-b border-gray-100">
                            <td class="py-4">
                                <div class="flex items-center">
                                    <img src="{{ asset('storage/' . $article->gambar) }}" alt="Thumbnail"
                                        class="w-10 h-10 rounded object-cover mr-3">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $article->judul }}</p>
                                        <p class="text-sm text-gray-500">{{ $article->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">{{ number_format($article->views) }}</td>
                            <td class="py-4">
                                {{ $article->avg_time_on_page ? gmdate('i:s', $article->avg_time_on_page) : '00:00' }}
                            </td>
                            <td class="py-4">{{ round($article->bounce_rate, 1) }}%</td>
                            <td class="py-4">
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">
                                    {{ $article->kategori->nama }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-500">No data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- User Engagement Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Device Distribution -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Device Distribution</h3>
            <div class="h-64">
                <canvas id="deviceChart"></canvas>
            </div>
        </div>

        <!-- Traffic Sources -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Traffic Sources</h3>
            <div class="h-64">
                <canvas id="sourcesChart"></canvas>
            </div>
        </div>

        <!-- User Demographics -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">User Demographics</h3>
            <div class="h-64">
                <canvas id="demographicsChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Helper untuk fallback data jika variabel null
var deviceData = {
    !!isset($deviceData) ? json_encode($deviceData) : '[0,0,0]'!!
};
var sourceData = {
    !!isset($sourceData) ? json_encode($sourceData) : '[0,0,0,0]'!!
};
var demographicsData = {
    !!isset($demographicsData) ? json_encode($demographicsData) : '[0,0,0,0,0]'!!
};
var trafficLabels = {
    !!isset($trafficLabels) ? json_encode($trafficLabels) : '[]'!!
};
var trafficValues = {
    !!isset($trafficValues) ? json_encode($trafficValues) : '[]'!!
};
var categoryLabels = {
    !!isset($categoryLabels) ? json_encode($categoryLabels) : '[]'!!
};
var categoryValues = {
    !!isset($categoryValues) ? json_encode($categoryValues) : '[]'!!
};

document.addEventListener('DOMContentLoaded', function() {
    new Chart(document.getElementById('trafficChart'), {
        type: 'line',
        data: {
            labels: trafficLabels,
            datasets: [{
                label: 'Page Views',
                data: trafficValues,
                borderColor: '#2563eb',
                tension: 0.3,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
    new Chart(document.getElementById('categoriesChart'), {
        type: 'bar',
        data: {
            labels: categoryLabels,
            datasets: [{
                label: 'Articles by Category',
                data: categoryValues,
                backgroundColor: '#93c5fd'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
    new Chart(document.getElementById('deviceChart'), {
        type: 'doughnut',
        data: {
            labels: ['Desktop', 'Mobile', 'Tablet'],
            datasets: [{
                data: deviceData,
                backgroundColor: ['#3b82f6', '#ef4444', '#10b981']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
    new Chart(document.getElementById('sourcesChart'), {
        type: 'pie',
        data: {
            labels: ['Direct', 'Social', 'Search', 'Referral'],
            datasets: [{
                data: sourceData,
                backgroundColor: ['#6366f1', '#f59e0b', '#ec4899', '#8b5cf6']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
    new Chart(document.getElementById('demographicsChart'), {
        type: 'bar',
        data: {
            labels: ['18-24', '25-34', '35-44', '45-54', '55+'],
            datasets: [{
                label: 'Age Distribution',
                data: demographicsData,
                backgroundColor: '#a78bfa'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y'
        }
    });
});
</script>
@endpush
@endsection