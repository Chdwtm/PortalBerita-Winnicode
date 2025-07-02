@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-8">
        <article class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Article Header -->
            <div class="p-4 sm:p-6">
                <div class="flex flex-wrap items-center gap-2 sm:gap-4 mb-4">
                    <span class="bg-red-600 text-white px-3 py-1 rounded-full text-xs sm:text-sm font-medium">
                        {{ $berita->kategori->nama }}
                    </span>
                    <span class="text-gray-500 text-xs sm:text-sm">
                        <i class="fas fa-clock mr-1"></i>
                        {{ $berita->created_at->format('d M Y, H:i') }}
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">{{ $berita->judul }}</h1>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <i class="fas fa-user-circle text-2xl text-gray-400 mr-2"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $berita->penulis->name }}</p>
                                <p class="text-xs text-gray-500">Penulis</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 text-xs sm:text-sm text-gray-500">
                        <span><i class="fas fa-eye mr-1"></i> {{ $berita->views }} views</span>
                        <span><i class="fas fa-comment mr-1"></i> {{ $komentars->count() }} komentar</span>
                    </div>
                </div>
            </div>

            <!-- Article Image -->
            @if($berita->gambar)
            <div class="relative h-64 sm:h-96">
                <img src="{{ Storage::url($berita->gambar) }}" 
                     alt="{{ $berita->judul }}"
                     class="w-full h-full object-cover">
            </div>
            @endif

            <!-- Article Content -->
            <div class="p-4 sm:p-6">
                <div class="prose max-w-none prose-sm sm:prose-base">
                    {!! $berita->konten !!}
                </div>

                <!-- Reactions -->
                <div class="flex flex-wrap items-center gap-4 mt-6 sm:mt-8 pt-6 border-t border-gray-100">
                    @auth
                        <button onclick="react('like')" 
                                class="flex items-center space-x-2 px-4 py-2 rounded-full text-sm {{ $berita->user_reaction === 'like' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600' }} hover:bg-blue-100 hover:text-blue-600 transition-colors">
                            <i class="fas fa-thumbs-up"></i>
                            <span>{{ $berita->likes_count }}</span>
                        </button>
                        <button onclick="react('dislike')" 
                                class="flex items-center space-x-2 px-4 py-2 rounded-full text-sm {{ $berita->user_reaction === 'dislike' ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600' }} hover:bg-red-100 hover:text-red-600 transition-colors">
                            <i class="fas fa-thumbs-down"></i>
                            <span>{{ $berita->dislikes_count }}</span>
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-500">Login untuk memberikan reaksi</a>
                    @endauth
                </div>
            </div>
        </article>

        <!-- Comments Section -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mt-6 sm:mt-8">
            <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-6">Komentar ({{ $komentars->count() }})</h3>
            
            @auth
            <form action="{{ route('berita.komentar', $berita) }}" method="POST" class="mb-6 sm:mb-8">
                @csrf
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-shrink-0 hidden sm:block">
                        <i class="fas fa-user-circle text-3xl text-gray-400"></i>
                    </div>
                    <div class="flex-grow">
                        <textarea name="konten" rows="3" 
                                  class="w-full px-4 py-2 text-sm sm:text-base rounded-lg border border-gray-200 focus:ring-2 focus:ring-red-600 focus:border-transparent @error('konten') border-red-500 @enderror"
                                  placeholder="Tulis komentar Anda...">{{ old('konten') }}</textarea>
                        @error('konten')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <button type="submit" 
                                class="mt-2 px-4 sm:px-6 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors">
                            Kirim Komentar
                        </button>
                    </div>
                </div>
            </form>
            @else
            <div class="bg-gray-50 rounded-lg p-4 text-center mb-6 sm:mb-8">
                <p class="text-gray-600 text-sm">
                    <a href="{{ route('login') }}" class="text-red-600 hover:underline">Login</a> 
                    untuk memberikan komentar
                </p>
            </div>
            @endauth

            <div class="space-y-4 sm:space-y-6">
                @foreach($komentars as $komentar)
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-shrink-0 hidden sm:block">
                        <i class="fas fa-user-circle text-3xl text-gray-400"></i>
                    </div>
                    <div class="flex-grow">
                        <div class="bg-gray-50 rounded-lg p-3 sm:p-4">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                                <h4 class="font-medium text-gray-800 text-sm sm:text-base">{{ $komentar->user->name }}</h4>
                                <span class="text-xs text-gray-500">
                                    {{ $komentar->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm sm:text-base">{{ $komentar->komentar }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-4 space-y-6">
        <!-- Related News -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
            <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">Berita Terkait</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
                @foreach(\App\Models\Berita::where('kategori_id', $berita->kategori_id)
                        ->where('id', '!=', $berita->id)
                        ->latest()
                        ->take(5)
                        ->get() as $relatedNews)
                <a href="{{ route('berita.show', $relatedNews) }}" class="block group">
                    <div class="relative h-40 rounded-lg overflow-hidden mb-2">
                        @if($relatedNews->gambar)
                            <img src="{{ Storage::url($relatedNews->gambar) }}" 
                                 alt="{{ $relatedNews->judul }}"
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                <i class="fas fa-newspaper text-2xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    <h4 class="font-semibold text-gray-800 group-hover:text-red-600 transition-colors text-sm sm:text-base">
                        {{ $relatedNews->judul }}
                    </h4>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                        {{ $relatedNews->created_at->diffForHumans() }}
                    </p>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Popular Tags -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
            <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">Kategori Populer</h3>
            <div class="flex flex-wrap gap-2">
                @foreach(\App\Models\Kategori::withCount('beritas')
                        ->orderBy('beritas_count', 'desc')
                        ->take(10)
                        ->get() as $kategori)
                <a href="{{ route('berita.kategori', $kategori) }}" 
                   class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs sm:text-sm hover:bg-red-100 hover:text-red-600 transition-colors">
                    {{ $kategori->nama }}
                    <span class="text-xs">({{ $kategori->beritas_count }})</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

@auth
<script>
function react(type) {
    fetch(`/berita/{{ $berita->id }}/reaction`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ type: type })
    }).then(response => {
        if (response.ok) {
            window.location.reload();
        }
    });
}
</script>
@endauth
@endsection