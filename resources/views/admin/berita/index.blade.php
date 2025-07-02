@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Berita</h1>
            <p class="text-gray-500">Kelola semua berita dalam satu tempat</p>
        </div>
        <div>
            <a href="{{ route('admin.berita.create') }}"
                class="inline-flex items-center px-5 py-2 rounded-full bg-indigo-600 text-white font-semibold shadow hover:bg-indigo-700 transition">
                <i class="fas fa-plus-circle fa-sm mr-2"></i> Tambah Berita
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div
            class="flex items-center bg-gradient-to-r from-indigo-500 to-blue-800 text-white rounded-xl shadow p-4 gap-3">
            <i class="fas fa-newspaper fa-lg"></i>
            <div>
                <div class="text-sm opacity-85">Total Berita</div>
                <div class="text-lg font-bold">{{ $beritas->total() }}</div>
            </div>
        </div>
        <div
            class="flex items-center bg-gradient-to-r from-green-400 to-green-800 text-white rounded-xl shadow p-4 gap-3">
            <i class="fas fa-eye fa-lg"></i>
            <div>
                <div class="text-sm opacity-85">Total Views</div>
                <div class="text-lg font-bold">{{ number_format($beritas->sum('views')) }}</div>
            </div>
        </div>
        <div
            class="flex items-center bg-gradient-to-r from-cyan-500 to-cyan-800 text-white rounded-xl shadow p-4 gap-3">
            <i class="fas fa-microchip fa-lg"></i>
            <div>
                <div class="text-sm opacity-85">Berita Teknologi</div>
                <div class="text-lg font-bold">{{ $beritas->where('kategori.nama', 'Teknologi')->count() }}</div>
            </div>
        </div>
        <div
            class="flex items-center bg-gradient-to-r from-yellow-400 to-yellow-700 text-white rounded-xl shadow p-4 gap-3">
            <i class="fas fa-running fa-lg"></i>
            <div>
                <div class="text-sm opacity-85">Berita Olahraga</div>
                <div class="text-lg font-bold">{{ $beritas->where('kategori.nama', 'Olahraga')->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white shadow rounded-xl mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 px-6 py-4 border-b">
            <h6 class="font-bold text-indigo-700">Daftar Berita</h6>
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex rounded-full shadow bg-gray-100 overflow-hidden w-56">
                    <input type="text" class="flex-1 px-4 py-2 bg-gray-100 text-sm focus:outline-none"
                        placeholder="Cari berita...">
                    <button class="px-4 text-indigo-600 hover:text-indigo-800">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="relative">
                    <button
                        class="flex items-center px-4 py-2 border border-indigo-500 text-indigo-600 rounded-full shadow hover:bg-indigo-50 transition"
                        type="button">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                    <!-- Example dropdown, implement with Alpine.js or Livewire for real filter -->
                    <div class="hidden absolute right-0 mt-2 w-40 bg-white border rounded shadow-lg z-10">
                        <a class="block px-4 py-2 text-indigo-600 font-semibold bg-indigo-50" href="#">Semua
                            Kategori</a>
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">Teknologi</a>
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">Olahraga</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-4">
            @if(session('success'))
            <div class="flex items-center bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4">
                <i class="fas fa-check-circle fa-lg mr-2"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
            @endif
            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full text-sm text-left border-t border-b">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="text-center py-2 px-3 font-semibold">No</th>
                            <th class="py-2 px-3 font-semibold">Judul & Informasi</th>
                            <th class="text-center py-2 px-3 font-semibold">Kategori</th>
                            <th class="text-center py-2 px-3 font-semibold">Views</th>
                            <th class="text-center py-2 px-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($beritas as $index => $berita)
                        <tr class="border-b hover:bg-blue-50">
                            <td class="text-center font-bold py-2">{{ $index + 1 }}</td>
                            <td class="py-2">
                                <div class="flex items-center gap-3">
                                    @if($berita->gambar)
                                    <img src="{{ asset('storage/' . $berita->gambar) }}"
                                        class="w-11 h-11 object-cover rounded-md shadow">
                                    @else
                                    <div
                                        class="w-11 h-11 rounded-md bg-gray-100 flex items-center justify-center shadow">
                                        <i class="fas fa-image text-gray-400 fa-lg"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-gray-800">{{ $berita->judul }}</div>
                                        <div class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                                            <i class="fas fa-user-edit"></i> {{ $berita->penulis->name ?? 'Admin' }}
                                            <span>•</span>
                                            <i class="far fa-clock"></i> {{ $berita->created_at->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($berita->kategori->nama == 'Teknologi')
                                <span
                                    class="bg-cyan-100 text-cyan-700 font-semibold px-3 py-1 rounded-full inline-block text-xs">
                                    <i class="fas fa-microchip mr-1"></i> Teknologi
                                </span>
                                @else
                                <span
                                    class="bg-green-100 text-green-700 font-semibold px-3 py-1 rounded-full inline-block text-xs">
                                    <i class="fas fa-running mr-1"></i> Olahraga
                                </span>
                                @endif
                            </td>
                            <td class="text-center text-indigo-600 font-bold">{{ number_format($berita->views) }}</td>
                            <td class="text-center">
                                <div class="flex justify-center gap-1">
                                    <a href="{{ route('berita.show', $berita) }}"
                                        class="bg-cyan-500 hover:bg-cyan-600 text-white px-3 py-1 rounded shadow text-xs"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.berita.edit', $berita) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow text-xs"
                                        title="Edit Berita">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.berita.destroy', $berita) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow text-xs"
                                            title="Hapus Berita">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 gap-2">
                <div class="text-gray-500 text-sm">
                    Menampilkan {{ $beritas->firstItem() ?? 0 }} sampai {{ $beritas->lastItem() ?? 0 }} dari
                    {{ $beritas->total() }} data
                </div>
                <div>
                    {{ $beritas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection