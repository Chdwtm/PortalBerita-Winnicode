@extends('layouts.app')

@section('content')
<div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-8">
            <article class="bg-white rounded-xl shadow-sm overflow-hidden">
                <!-- Article Header -->
                <div class="p-4 sm:p-6">
                    <div class="flex flex-wrap items-center gap-2 sm:gap-4 mb-4">
                        <span class="bg-red-600 text-white px-3 py-1 rounded-full text-xs sm:text-sm font-medium">
                            Nasional
                        </span>
                        <span class="text-gray-500 text-xs sm:text-sm">
                            <i class="fas fa-clock mr-1"></i>
                            {{ \Carbon\Carbon::parse($selectedNews['publishedAt'])->format('d M Y') }}
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">
                        {{ $selectedNews['title'] ?? 'Judul Tidak Tersedia' }}</h1>
                    <div
                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-100">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <i class="fas fa-user-circle text-2xl text-gray-400 mr-2"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">
                                        {{ $selectedNews['source']['name'] ?? 'Tidak diketahui' }}</p>
                                    <p class="text-xs text-gray-500">Sumber</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Article Image -->
                @if(!empty($selectedNews['urlToImage']))
                <div class="relative h-64 sm:h-96">
                    <img src="{{ $selectedNews['urlToImage'] }}" alt="Gambar Berita" class="w-full h-full object-cover">
                </div>
                @endif
                <!-- Article Content -->
                <div class="p-4 sm:p-6">
                    <div class="prose max-w-none prose-sm sm:prose-base">
                        {{ $selectedNews['content'] ?? 'Konten tidak tersedia.' }}
                    </div>
                    @if(!empty($selectedNews['original_url']))
                    <a href="{{ $selectedNews['original_url'] }}"
                        class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                        target="_blank">
                        Baca di Website Asli
                    </a>
                    @endif
                    <a href="{{ route('home') }}"
                        class="mt-4 ml-2 inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </article>
            <!-- Comments Section -->
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mt-6 sm:mt-8">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-6">Komentar</h3>
                <div class="bg-gray-50 rounded-lg p-4 text-center mb-6 sm:mb-8">
                    <p class="text-gray-600 text-sm">
                        Komentar untuk berita nasional API belum tersedia.
                    </p>
                </div>
            </div>
        </div>
        <!-- Sidebar kosong agar layout tetap rapi -->
        <div class="lg:col-span-4"></div>
    </div>
</div>
@endsection