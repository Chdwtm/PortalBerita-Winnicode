@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumbs')
<nav class="text-sm text-gray-500 mb-4 bg-white p-4 rounded-lg shadow-sm" aria-label="Breadcrumb">
    <ol class="list-none p-0 inline-flex">
        <li class="flex items-center">
            <i class="fas fa-home text-blue-500"></i>
            <span class="ml-2 font-medium">Dashboard</span>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container px-6 mx-auto grid">
    <div class="flex justify-between items-center my-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Dashboard Overview
        </h2>
        <div class="flex space-x-3">
            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">Today</span>
            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200">Week</span>
            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200">Month</span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Total Berita Card -->
        <div class="transform transition-transform duration-300 hover:scale-105">
            <div class="flex items-center p-6 bg-gradient-to-r from-orange-500 to-pink-500 rounded-lg shadow-lg">
                <div class="p-3 mr-4 bg-white bg-opacity-30 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-white text-opacity-80">
                        Total Berita
                    </p>
                    <p class="text-2xl font-bold text-white">
                        {{ $stats['total_berita'] }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Views Card -->
        <div class="transform transition-transform duration-300 hover:scale-105">
            <div class="flex items-center p-6 bg-gradient-to-r from-green-500 to-teal-500 rounded-lg shadow-lg">
                <div class="p-3 mr-4 bg-white bg-opacity-30 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-white text-opacity-80">
                        Total Views
                    </p>
                    <p class="text-2xl font-bold text-white">
                        {{ $stats['total_views'] }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="transform transition-transform duration-300 hover:scale-105">
            <div class="flex items-center p-6 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg shadow-lg">
                <div class="p-3 mr-4 bg-white bg-opacity-30 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-white text-opacity-80">
                        Total Users
                    </p>
                    <p class="text-2xl font-bold text-white">
                        {{ $stats['total_users'] }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Comments Card -->
        <div class="transform transition-transform duration-300 hover:scale-105">
            <div class="flex items-center p-6 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg shadow-lg">
                <div class="p-3 mr-4 bg-white bg-opacity-30 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-white text-opacity-80">
                        Total Comments
                    </p>
                    <p class="text-2xl font-bold text-white">
                        {{ $stats['total_komentar'] }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Content Section -->
    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <!-- Recent News -->
        <div class="min-w-0 p-6 bg-white rounded-lg shadow-lg border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/>
                    </svg>
                    Recent News
                </h4>
                <a href="#" class="text-sm text-blue-500 hover:text-blue-600 font-medium">View all</a>
            </div>
            <div class="w-full overflow-hidden space-y-5">
                @foreach($recentBerita as $berita)
                <div class="transform transition-all duration-300 hover:scale-[1.02]">
                    <div class="p-4 rounded-lg bg-gray-50 hover:bg-blue-50 transition-colors duration-200">
                        <p class="text-gray-800 font-medium mb-2">
                            <a href="{{ route('berita.show', $berita) }}" class="hover:text-blue-600">
                                {{ $berita->judul }}
                            </a>
                        </p>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            {{ $berita->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Comments -->
        <div class="min-w-0 p-6 bg-white rounded-lg shadow-lg border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"/>
                    </svg>
                    Recent Comments
                </h4>
                <a href="#" class="text-sm text-purple-500 hover:text-purple-600 font-medium">View all</a>
            </div>
            <div class="w-full overflow-hidden space-y-5">
                @foreach($recentKomentar as $komentar)
                <div class="transform transition-all duration-300 hover:scale-[1.02]">
                    <div class="p-4 rounded-lg bg-gray-50 hover:bg-purple-50 transition-colors duration-200">
                        <p class="text-gray-700 mb-2">{{ Str::limit($komentar->komentar, 100) }}</p>
                        <div class="flex items-center text-sm">
                            <span class="text-purple-600 font-medium">{{ $komentar->user->name }}</span>
                            <span class="mx-2 text-gray-400">•</span>
                            <a href="{{ route('berita.show', $komentar->berita) }}" class="text-gray-500 hover:text-purple-600">
                                {{ Str::limit($komentar->berita->judul, 50) }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection