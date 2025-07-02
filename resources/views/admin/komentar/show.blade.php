@extends('layouts.admin')

@section('title', 'Detail Komentar')

@section('content')
<div class="container px-6 mx-auto">
    <div class="py-6">
        <h2 class="text-2xl font-semibold text-gray-700">Detail Komentar</h2>
        <nav class="text-sm text-gray-500 mt-1" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">
                        <i class="fas fa-home"></i>
                    </a>
                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('admin.komentar.index') }}" class="hover:text-gray-700">Kelola Komentar</a>
                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                </li>
                <li>Detail Komentar</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Informasi Komentar</h3>
                <div class="mt-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pengguna</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $komentar->user->name }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Berita</label>
                        <div class="mt-1 text-sm text-gray-900">
                            <a href="{{ route('berita.show', $komentar->berita) }}" class="text-red-600 hover:text-red-700">
                                {{ $komentar->berita->judul }}
                            </a>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Komentar</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $komentar->konten }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Dibuat</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $komentar->created_at->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end space-x-3">
            <a href="{{ route('admin.komentar.index') }}"
               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Kembali
            </a>
            <form action="{{ route('admin.komentar.destroy', $komentar) }}" method="POST" class="inline"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Hapus Komentar
                </button>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
<div id="alert" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
    {{ session('success') }}
</div>
@endif

<script>
// Auto hide alerts after 3 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alert = document.getElementById('alert');
    if (alert) {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease-in-out';
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    }
});
</script>
@endsection 