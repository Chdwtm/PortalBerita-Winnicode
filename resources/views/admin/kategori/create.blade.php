@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container px-6 mx-auto">
    <div class="py-6">
        <h2 class="text-2xl font-semibold text-gray-700">Tambah Kategori</h2>
        <nav class="text-sm text-gray-500 mt-1" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">
                        <i class="fas fa-home"></i>
                    </a>
                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('admin.kategori.index') }}" class="hover:text-gray-700">Kelola Kategori</a>
                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                </li>
                <li>Tambah Kategori</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="{{ route('admin.kategori.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('nama') border-red-500 @enderror">
                    @error('nama')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.kategori.index') }}"
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Batal
                </a>
                <button type="submit"
                        class="bg-red-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 