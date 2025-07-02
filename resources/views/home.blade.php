@extends('layouts.app')

@section('content')
    <!-- Hero Section - Featured News -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
        @php
            $featuredNews = $beritas->first();
            $secondaryNews = $beritas->slice(1, 2);
        @endphp

        @if($featuredNews)
        <!-- Main Featured News -->
        <div class="lg:col-span-2 relative group">
            <a href="{{ route('berita.show', $featuredNews) }}" class="block">
                <div class="relative h-64 sm:h-96 overflow-hidden rounded-xl">
                    @if($featuredNews->gambar)
                        <img src="{{ Storage::url($featuredNews->gambar) }}" 
                             alt="{{ $featuredNews->judul }}"
                             class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                            <i class="fas fa-newspaper text-4xl text-gray-400"></i>
                        </div>
                    @endif
                    <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 bg-gradient-to-t from-black to-transparent">
                        <span class="bg-red-600 text-white px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium">
                            {{ $featuredNews->kategori->nama }}
                        </span>
                        <h2 class="text-xl sm:text-2xl font-bold text-white mt-2">{{ $featuredNews->judul }}</h2>
                        <div class="flex items-center mt-2 sm:mt-3 text-white text-xs sm:text-sm">
                            <i class="fas fa-user-circle mr-2"></i>
                            <span>{{ $featuredNews->penulis->name }}</span>
                            <i class="fas fa-clock mx-2"></i>
                            <span>{{ $featuredNews->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Secondary Featured News -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4 sm:gap-6">
            @foreach($secondaryNews as $news)
            <a href="{{ route('berita.show', $news) }}" class="block group">
                <div class="relative h-48 sm:h-44 overflow-hidden rounded-xl">
                    @if($news->gambar)
                        <img src="{{ Storage::url($news->gambar) }}" 
                             alt="{{ $news->judul }}"
                             class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                            <i class="fas fa-newspaper text-2xl text-gray-400"></i>
                        </div>
                    @endif
                    <div class="absolute bottom-0 left-0 right-0 p-3 sm:p-4 bg-gradient-to-t from-black to-transparent">
                        <span class="bg-red-600 text-white px-2 py-1 rounded-full text-xs font-medium">
                            {{ $news->kategori->nama }}
                        </span>
                        <h3 class="text-base sm:text-lg font-bold text-white mt-2">{{ $news->judul }}</h3>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>

    <!-- News Categories Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
        <!-- Main News Content -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6">Berita Terbaru</h2>
                <div class="space-y-6">
                    @foreach($beritaTerbaruGabungan as $berita)
                        @if(isset($berita['is_nasional']) && $berita['is_nasional'])
                            <article class="flex flex-col sm:flex-row gap-4 sm:gap-6 pb-6 border-b border-gray-100 last:border-0">
                                <div class="sm:w-1/3">
                                    <a href="{{ route('berita.nasional.show', $loop->index) }}" class="block relative h-48 sm:h-40 rounded-lg overflow-hidden">
                                        @if(isset($berita['image']['large']) && $berita['image']['large'])
                                            <img src="{{ $berita['image']['large'] }}" alt="{{ $berita['title'] }}" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                                <i class="fas fa-newspaper text-2xl text-gray-400"></i>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                <div class="sm:w-2/3">
                                    <a href="{{ route('berita.nasional.show', $loop->index) }}">
                                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 hover:text-red-600 transition-colors">
                                            {{ $berita['title'] ?? '-' }} <span class="text-xs text-blue-600">(Nasional)</span>
                                        </h3>
                                    </a>
                                    <p class="text-gray-600 mt-2 text-sm sm:text-base line-clamp-2">
                                        {{ Str::limit(strip_tags($berita['content'] ?? ''), 150) }}
                                    </p>
                                    <div class="flex flex-wrap items-center gap-3 mt-3 text-xs sm:text-sm text-gray-500">
                                        <span><i class="fas fa-clock mr-1"></i>{{ \Carbon\Carbon::parse($berita['pubDate'] ?? now())->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </article>
                        @elseif(isset($berita['id']))
                            <article class="flex flex-col sm:flex-row gap-4 sm:gap-6 pb-6 border-b border-gray-100 last:border-0">
                                <div class="sm:w-1/3">
                                    <a href="{{ route('berita.show', $berita['id']) }}" class="block relative h-48 sm:h-40 rounded-lg overflow-hidden">
                                        @if(!empty($berita['gambar']))
                                            <img src="{{ Storage::url($berita['gambar']) }}" alt="{{ $berita['judul'] ?? '-' }}" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                                <i class="fas fa-newspaper text-2xl text-gray-400"></i>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                <div class="sm:w-2/3">
                                    <a href="{{ route('berita.show', $berita['id']) }}">
                                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 hover:text-red-600 transition-colors">
                                            {{ $berita['judul'] ?? '-' }}
                                        </h3>
                                    </a>
                                    <p class="text-gray-600 mt-2 text-sm sm:text-base line-clamp-2">
                                        {{ Str::limit(strip_tags($berita['konten'] ?? ''), 150) }}
                                    </p>
                                    <div class="flex flex-wrap items-center gap-3 mt-3 text-xs sm:text-sm text-gray-500">
                                        <span><i class="fas fa-user-circle mr-1"></i>{{ $berita['penulis']['name'] ?? '-' }}</span>
                                        <span><i class="fas fa-clock mr-1"></i>{{ \Carbon\Carbon::parse($berita['created_at'] ?? now())->diffForHumans() }}</span>
                                        <span><i class="fas fa-eye mr-1"></i>{{ $berita['views'] ?? 0 }} views</span>
                                    </div>
                                </div>
                            </article>
                        @endif
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $beritas->links() }}
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Berita Nasional -->
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">Berita Nasional</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
                    @forelse($beritaNasional as $news)
                    <a href="{{ route('berita.nasional.show', $loop->index) }}" target="_self" class="block group">
                        <div class="relative h-40 rounded-lg overflow-hidden mb-2">
                            @if(isset($news['image']['large']) && $news['image']['large'])
                                <img src="{{ $news['image']['large'] }}" 
                                     alt="{{ $news['title'] }}"
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                    <i class="fas fa-newspaper text-2xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <h3 class="font-semibold text-gray-800 group-hover:text-red-600 transition-colors line-clamp-2 text-sm sm:text-base">
                            {{ $news['title'] ?? '-' }}
                        </h3>
                    </a>
                    @empty
                        <div class="text-gray-500 text-center">Tidak ada berita nasional tersedia.</div>
                    @endforelse
                </div>
            </div>
            <!-- End Berita Nasional -->

            <!-- International News -->
            <!--
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">Berita Internasional</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
                    @foreach($newsFromAPI as $index => $news)
                    <a href="{{ route('berita.international.show', $index) }}" class="block group">
                        <div class="relative h-40 rounded-lg overflow-hidden mb-2">
                            @if(isset($news['urlToImage']))
                                <img src="{{ $news['urlToImage'] }}" 
                                     alt="{{ $news['title'] }}"
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                    <i class="fas fa-newspaper text-2xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <h3 class="font-semibold text-gray-800 group-hover:text-red-600 transition-colors line-clamp-2 text-sm sm:text-base">
                            {{ $news['title'] }}
                        </h3>
                    </a>
                    @endforeach
                </div>
            </div>
            -->
            <!-- Popular News -->
            @if(isset($beritaPopuler))
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">Berita Populer</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
                    @foreach($beritaPopuler as $berita)
                    <a href="{{ route('berita.show', $berita) }}" class="flex items-center gap-3 group">
                        <div class="relative w-20 h-20 rounded-lg overflow-hidden flex-shrink-0">
                            @if($berita->gambar)
                                <img src="{{ Storage::url($berita->gambar) }}" 
                                     alt="{{ $berita->judul }}"
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                    <i class="fas fa-newspaper text-xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-semibold text-gray-800 group-hover:text-red-600 transition-colors line-clamp-2 text-sm">
                                {{ $berita->judul }}
                            </h3>
                            <div class="flex items-center mt-1 text-xs text-gray-500">
                                <i class="fas fa-eye mr-1"></i>
                                <span>{{ $berita->views }} views</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection