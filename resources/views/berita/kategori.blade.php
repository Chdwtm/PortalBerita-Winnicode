@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Category Header -->
    <div class="bg-white rounded-xl shadow-sm mb-6 p-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">{{ $kategori->nama }}</h1>
        <p class="text-gray-500">
            Menampilkan {{ $beritas->count() }} berita dalam kategori ini
        </p>
    </div>

    <!-- News Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($beritas as $berita)
        <article class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow">
            @if($berita->gambar)
            <div class="aspect-w-16 aspect-h-9">
                <img src="{{ asset('storage/' . $berita->gambar) }}" 
                     alt="{{ $berita->judul }}"
                     class="w-full h-48 object-cover">
            </div>
            @endif
            
            <div class="p-4">
                <div class="flex items-center gap-2 mb-3">
                    <span class="bg-red-600 text-white px-3 py-1 rounded-full text-xs">
                        {{ $berita->kategori->nama }}
                    </span>
                    <span class="text-gray-500 text-xs">
                        {{ $berita->created_at->format('d M Y') }}
                    </span>
                </div>
                
                <h2 class="text-xl font-semibold text-gray-800 mb-2 line-clamp-2">
                    <a href="{{ route('berita.show', $berita) }}" class="hover:text-red-600">
                        {{ $berita->judul }}
                    </a>
                </h2>
                
                <div class="text-gray-600 line-clamp-3 mb-4">
                    {{ Str::limit(strip_tags($berita->konten), 150) }}
                </div>
                
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <div class="flex items-center gap-4">
                        <span><i class="fas fa-eye mr-1"></i> {{ $berita->views }}</span>
                        <span><i class="fas fa-comment mr-1"></i> {{ $berita->komentars->count() }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-user-circle text-gray-400 mr-2"></i>
                        <span>{{ $berita->penulis->name }}</span>
                    </div>
                </div>
            </div>
        </article>
        @empty
        <div class="col-span-full text-center py-12">
            <div class="text-gray-500">
                <i class="fas fa-newspaper text-4xl mb-4"></i>
                <p class="text-lg">Belum ada berita dalam kategori ini.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $beritas->links() }}
    </div>
</div>
@endsection 