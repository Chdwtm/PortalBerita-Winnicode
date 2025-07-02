@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Page Header -->
    <div class="bg-white shadow-sm rounded-lg mb-6 overflow-hidden border border-gray-200">
        <div
            class="px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between bg-gradient-to-r from-blue-50 to-indigo-50">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Berita</h1>
                <p class="mt-1 text-sm text-gray-600">Perbarui informasi berita yang sudah ada</p>
            </div>
            <nav class="mt-4 md:mt-0">
                <ol class="flex items-center space-x-1 text-sm">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            <i class="fas fa-home mr-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="flex items-center">
                        <span class="mx-2 text-gray-500">/</span>
                        <a href="{{ route('admin.berita.index') }}"
                            class="text-blue-600 hover:text-blue-800 font-medium">
                            <i class="fas fa-newspaper mr-1"></i> Berita
                        </a>
                    </li>
                    <li class="flex items-center">
                        <span class="mx-2 text-gray-500">/</span>
                        <span class="text-gray-600"><i class="fas fa-edit mr-1"></i> Edit Berita</span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
        <div class="p-6">
            @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm">
                <div class="flex items-center mb-2">
                    <div class="flex-shrink-0 bg-red-100 p-1 rounded-full">
                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                    </div>
                    <h5 class="font-semibold text-red-800 ml-2">Terjadi Kesalahan</h5>
                </div>
                <ul class="ml-8 text-sm text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                    <li class="flex items-start">
                        <i class="fas fa-times-circle text-red-400 mr-2 mt-0.5"></i>
                        <span>{{ $error }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2">
                        <!-- Judul Berita -->
                        <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white px-4 py-3">
                                <label for="judul" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-heading text-blue-500 mr-2"></i>
                                    Judul Berita <span class="text-red-500 ml-1">*</span>
                                </label>
                            </div>
                            <div class="p-4">
                                <input type="text"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-lg py-3 px-4 {{ $errors->has('judul') ? 'border-red-300' : '' }}"
                                    id="judul" name="judul" value="{{ old('judul', $berita->judul) }}"
                                    placeholder="Masukkan judul berita" required>
                                @error('judul')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Konten Berita -->
                        <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white px-4 py-3">
                                <label for="konten" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-paragraph text-blue-500 mr-2"></i>
                                    Konten Berita <span class="text-red-500 ml-1">*</span>
                                </label>
                            </div>
                            <div class="p-4">
                                <div class="border border-gray-300 rounded-md overflow-hidden">
                                    <textarea
                                        class="block w-full shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 {{ $errors->has('konten') ? 'border-red-300' : '' }}"
                                        id="editor" name="konten" rows="12" placeholder="Tulis konten berita di sini..."
                                        required>{{ old('konten', $berita->konten) }}</textarea>
                                </div>
                                @error('konten')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <div
                            class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3 text-white">
                                <h2 class="font-semibold flex items-center">
                                    <i class="fas fa-cog mr-2"></i> Pengaturan Berita
                                </h2>
                            </div>
                            <div class="p-5">
                                <!-- Kategori -->
                                <div class="mb-6">
                                    <label for="kategori_id"
                                        class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-tag text-blue-500 mr-2"></i>
                                        Kategori <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <select
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 {{ $errors->has('kategori_id') ? 'border-red-300' : '' }}"
                                        id="kategori_id" name="kategori_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}"
                                            {{ old('kategori_id', $berita->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                    <p class="mt-1 text-sm text-red-600">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Gambar -->
                                <div class="mb-6">
                                    <label for="gambar"
                                        class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-image text-blue-500 mr-2"></i>
                                        Gambar Berita
                                    </label>
                                    @if($berita->gambar)
                                    <div class="mb-4 bg-white p-2 rounded-md shadow-sm border border-gray-200">
                                        <span class="block text-xs font-medium text-gray-500 mb-1 border-b pb-1">Gambar
                                            Saat Ini:</span>
                                        <div class="relative rounded-md overflow-hidden group">
                                            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Current Image"
                                                class="w-full h-auto max-h-40 object-cover">
                                            <div
                                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="mt-2">
                                        <div
                                            class="relative border-2 border-dashed border-blue-200 hover:border-blue-400 rounded-md overflow-hidden transition duration-300 bg-blue-50 bg-opacity-30 hover:bg-opacity-50">
                                            <input type="file"
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                                id="gambar" name="gambar" accept="image/*"
                                                onchange="previewImage(event)">
                                            <div
                                                class="py-3 px-4 text-sm text-gray-700 flex flex-col items-center justify-center">
                                                <i class="fas fa-cloud-upload-alt text-blue-500 text-xl mb-1"></i>
                                                <span id="file-label"
                                                    class="font-medium">{{ $berita->gambar ? 'Ganti gambar...' : 'Pilih gambar...' }}</span>
                                                <span class="text-xs text-gray-500 mt-1">Klik atau seret file ke
                                                    sini</span>
                                            </div>
                                        </div>
                                        <p class="mt-1.5 text-xs text-gray-500 flex items-center">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Format: JPG, PNG, GIF (Maks. 2MB)
                                        </p>
                                    </div>
                                    @error('gambar')
                                    <p class="mt-2 text-sm text-red-600">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                    <div id="imagePreview" class="mt-4 hidden">
                                        <div class="bg-white p-2 rounded-md shadow-sm border border-gray-200">
                                            <span
                                                class="block text-xs font-medium text-gray-500 mb-1 border-b pb-1">Preview
                                                Gambar Baru:</span>
                                            <div class="rounded-md overflow-hidden">
                                                <img src="" class="w-full h-auto" id="preview">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-6 border-t border-gray-200">

                                <!-- Informasi Tambahan -->
                                <div class="mb-6">
                                    <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                        Informasi Berita
                                    </h3>
                                    <div class="bg-white rounded-md border border-gray-200 shadow-sm overflow-hidden">
                                        <div class="divide-y divide-gray-100">
                                            <div
                                                class="flex items-center px-4 py-3 bg-blue-50 bg-opacity-50 hover:bg-opacity-70 transition-colors">
                                                <div
                                                    class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                                    <i class="far fa-calendar-alt text-blue-500"></i>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500 mb-0.5">Dibuat pada</p>
                                                    <p class="text-sm font-medium text-gray-700">
                                                        {{ $berita->created_at->format('d M Y, H:i') }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors">
                                                <div
                                                    class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                                    <i class="far fa-eye text-green-500"></i>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500 mb-0.5">Total dilihat</p>
                                                    <p class="text-sm font-medium text-gray-700">
                                                        {{ number_format($berita->views) }} kali</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors">
                                                <div
                                                    class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                                    <i class="far fa-user text-indigo-500"></i>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500 mb-0.5">Penulis</p>
                                                    <p class="text-sm font-medium text-gray-700">
                                                        {{ $berita->penulis->name ?? 'Admin' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Submit -->
                                <div class="pt-4">
                                    <div
                                        class="bg-gray-50 border border-gray-200 rounded-md p-4 flex justify-between items-center">
                                        <a href="{{ route('admin.berita.index') }}"
                                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                            <i class="fas fa-arrow-left mr-2"></i>
                                            <span>Kembali</span>
                                        </a>
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 border border-transparent rounded-md shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                            <i class="fas fa-save mr-2"></i>
                                            <span>Simpan Perubahan</span>
                                        </button>
                                    </div>
                                    <div class="text-xs text-center mt-3 text-gray-500">
                                        Terakhir diperbarui: {{ $berita->updated_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- CSS Style telah dihapus untuk menghindari bentrok dengan Tailwind CSS -->

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
<script>
// Initialize CKEditor
ClassicEditor
    .create(document.querySelector('#editor'), {
        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote',
            'insertTable', 'mediaEmbed', '|', 'undo', 'redo'
        ],
        heading: {
            options: [{
                    model: 'paragraph',
                    title: 'Paragraph',
                    class: 'ck-heading_paragraph'
                },
                {
                    model: 'heading1',
                    view: 'h1',
                    title: 'Heading 1',
                    class: 'ck-heading_heading1'
                },
                {
                    model: 'heading2',
                    view: 'h2',
                    title: 'Heading 2',
                    class: 'ck-heading_heading2'
                },
                {
                    model: 'heading3',
                    view: 'h3',
                    title: 'Heading 3',
                    class: 'ck-heading_heading3'
                }
            ]
        }
    })
    .then(editor => {
        console.log('CKEditor initialized successfully');

        // Add custom styling to the editor
        const editorElement = document.querySelector('.ck-editor');
        if (editorElement) {
            editorElement.classList.add('rounded-md', 'overflow-hidden', 'shadow-sm');
        }
    })
    .catch(error => {
        console.error(error);
    });

// Image Preview
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    const fileLabel = document.getElementById('file-label');
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        preview.src = e.target.result;
        previewContainer.classList.remove('hidden');
        previewContainer.classList.add('block');

        // Add animation for preview
        preview.classList.add('animate-fade-in');
        setTimeout(() => {
            preview.classList.remove('animate-fade-in');
        }, 500);
    }

    if (file) {
        reader.readAsDataURL(file);

        // Truncate file name if too long
        const fileName = file.name.length > 25 ?
            file.name.substring(0, 22) + '...' :
            file.name;

        fileLabel.textContent = fileName;
        fileLabel.title = file.name; // Show full name on hover
    }
}

// Add this to your existing script section
document.addEventListener('DOMContentLoaded', function() {
    // Add custom animations and interactivity
    const formInputs = document.querySelectorAll('input, select, textarea');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.closest('.mb-6')?.classList.add('ring-1', 'ring-blue-200', 'ring-opacity-50');
        });

        input.addEventListener('blur', function() {
            this.closest('.mb-6')?.classList.remove('ring-1', 'ring-blue-200',
                'ring-opacity-50');
        });
    });
});
</script>

<style>
.animate-fade-in {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* CKEditor adjustments for Tailwind */
.ck-editor__editable {
    min-height: 300px;
}

.ck-toolbar {
    border-color: #e5e7eb !important;
    background: #f9fafb !important;
}

.ck-content {
    border-color: #e5e7eb !important;
}
</style>
@endpush
@endsection