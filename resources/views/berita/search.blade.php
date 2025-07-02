@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Search Header -->
    <div class="bg-white rounded-xl shadow-sm mb-6 p-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Hasil Pencarian: "{{ $keyword }}"</h1>
        <p class="text-gray-500">
            {{ $beritaGabungan->count() }} berita ditemukan (Lokal & Nasional)
        </p>
    </div>

    @if($beritaGabungan->isEmpty())
    <!-- Empty State -->
    <div class="bg-white rounded-xl shadow-sm p-8 text-center">
        <div class="max-w-md mx-auto">
            <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Tidak ada hasil</h2>
            <p class="text-gray-500 mb-4">Maaf, tidak ada berita yang cocok dengan pencarian Anda.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center text-red-600 hover:text-red-700">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
    @else
    <!-- Search Results Gabungan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($beritaGabungan as $berita)
        <article class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow">
            @if(!$berita['is_nasional'])
                @if(isset($berita['gambar']))
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ asset('storage/' . $berita['gambar']) }}" 
                         alt="{{ $berita['judul'] }}"
                         class="w-full h-48 object-cover">
                </div>
                @endif
            @else
                @if(isset($berita['image']) && is_string($berita['image']))
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ $berita['image'] }}"
                         alt="{{ is_string($berita['title'] ?? null) ? $berita['title'] : '' }}"
                         class="w-full h-48 object-cover">
                </div>
                @endif
            @endif
            <div class="p-4">
                <div class="flex items-center gap-2 mb-3">
                    @if(!$berita['is_nasional'])
                        <span class="bg-red-600 text-white px-3 py-1 rounded-full text-xs">
                            {{-- Pastikan kategori adalah string, bukan array --}}
                            @php
                                $kategoriNama = isset($berita['kategori']) && is_array($berita['kategori']) ? ($berita['kategori']['nama'] ?? '-') : ($berita['kategori'] ?? '-');
                            @endphp
                            {{ is_string($kategoriNama) ? $kategoriNama : '-' }}
                        </span>
                        <span class="text-gray-500 text-xs">
                            {{ \Carbon\Carbon::parse($berita['created_at'])->format('d M Y') }}
                        </span>
                    @else
                        <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs">Nasional (API)</span>
                        <span class="text-gray-500 text-xs">
                            {{ \Carbon\Carbon::parse($berita['pubDate'] ?? now())->format('d M Y') }}
                        </span>
                    @endif
                </div>
                <h2 class="text-xl font-semibold text-gray-800 mb-2 line-clamp-2">
                    @if(!$berita['is_nasional'])
                        <a href="{{ route('berita.show', $berita['id']) }}" class="hover:text-red-600">
                            {{ $berita['judul'] }}
                        </a>
                    @else
                        <a href="{{ $berita['link'] }}" target="_blank" rel="noopener" class="hover:text-blue-600">
                            {{ $berita['title'] }}
                        </a>
                    @endif
                </h2>
                <div class="text-gray-600 text-sm line-clamp-3 mb-4">
                    @if(!$berita['is_nasional'])
                        {{ Str::limit(strip_tags($berita['konten'] ?? ''), 150) }}
                    @else
                        {{ Str::limit(strip_tags($berita['description'] ?? ''), 150) }}
                    @endif
                </div>
                <div class="flex items-center justify-between text-sm text-gray-500">
                    @if(!$berita['is_nasional'])
                    <div class="flex items-center gap-4">
                        <span><i class="fas fa-eye mr-1"></i> {{ $berita['views'] ?? 0 }}</span>
                        <span><i class="fas fa-comment mr-1"></i> {{ $berita['komentars_count'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-user-circle text-gray-400 mr-2"></i>
                        <span>{{ is_array($berita['penulis'] ?? null) ? ($berita['penulis']['name'] ?? '-') : ($berita['penulis'] ?? '-') }}</span>
                    </div>
                    @else
                    <div class="flex items-center gap-4">
                        <span><i class="fas fa-globe mr-1"></i> Sumber: CNN Indonesia</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-user-circle text-gray-400 mr-2"></i>
                        <span>API Nasional</span>
                    </div>
                    @endif
                </div>
            </div>
        </article>
        @endforeach
    </div>
    <!-- Pagination Lokal -->
    @if($beritas->hasPages())
    <div class="mt-8">
        {{ $beritas->links() }}
    </div>
    @endif
    @endif
</div>
@endsection