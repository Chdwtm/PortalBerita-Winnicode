@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-6">
    <nav class="mb-6">
        <ol class="flex text-sm text-gray-500 space-x-2">
            <li><a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a></li>
            <li>/</li>
            <li class="text-gray-700 font-semibold">Tulis Berita Baru</li>
        </ol>
    </nav>

    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <h2 class="text-2xl font-bold mb-6 flex items-center gap-2 text-red-600"><i class="fas fa-pen-fancy"></i> Tulis
            Berita Baru</h2>
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <!-- Judul -->
            <div>
                <label for="judul" class="block font-semibold mb-1">Judul Berita</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                    placeholder="Masukkan judul berita..." required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:outline-none @error('judul') border-red-500 @enderror">
                @error('judul')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <!-- Kategori dan Gambar -->
            <div class="flex flex-col md:flex-row gap-6">
                <div class="flex-1">
                    <label for="kategori_id" class="block font-semibold mb-1">Kategori</label>
                    <select id="kategori_id" name="kategori_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:outline-none @error('kategori_id') border-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex-1">
                    <label for="gambar" class="block font-semibold mb-1">Gambar Berita</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*" onchange="previewImage(this)"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:outline-none @error('gambar') border-red-500 @enderror">
                    @error('gambar')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <div id="image-preview" class="mt-3 hidden text-center">
                        <img src="#" alt="Preview" class="mx-auto rounded-lg shadow max-h-40 object-cover">
                    </div>
                    <small class="text-gray-400 block mt-2">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                </div>
            </div>
            <!-- Konten -->
            <div>
                <label for="konten" class="block font-semibold mb-1">Konten Berita</label>
                <textarea id="konten" name="konten" rows="8" placeholder="Tulis isi berita di sini..." required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:outline-none @error('konten') border-red-500 @enderror">{{ old('konten') }}</textarea>
                @error('konten')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <!-- Status -->
            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" id="published" name="published" value="1"
                        class="rounded border-gray-300 text-red-600 focus:ring-red-500"
                        {{ old('published') ? 'checked' : '' }}>
                    <span class="ml-2">Publikasikan sekarang</span>
                </label>
                <p class="text-gray-400 text-xs mt-1">Jika tidak dicentang, berita akan disimpan sebagai draft.</p>
            </div>
            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-2">
                <button type="button" onclick="window.history.back()"
                    class="w-full sm:w-auto px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>
                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit" name="action" value="draft"
                        class="flex-1 sm:flex-none px-6 py-2 rounded-lg bg-gray-500 text-white hover:bg-gray-600 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Draft
                    </button>
                    <button type="submit" name="action" value="publish"
                        class="flex-1 sm:flex-none px-6 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Publikasikan
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- Tips & Shortcut -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        <div class="bg-gray-50 rounded-lg shadow p-5">
            <h3 class="font-semibold text-lg mb-3 flex items-center gap-2 text-yellow-500"><i
                    class="fas fa-lightbulb"></i> Tips Menulis</h3>
            <ul class="space-y-2 text-sm text-gray-700">
                <li><i class="fas fa-check-circle text-green-500 mr-1"></i><span class="font-semibold"> Judul yang
                        Menarik:</span> Buat judul informatif & menarik perhatian pembaca.</li>
                <li><i class="fas fa-check-circle text-green-500 mr-1"></i><span class="font-semibold"> Konten
                        Berkualitas:</span> Akurat, terstruktur, mudah dipahami.</li>
                <li><i class="fas fa-check-circle text-green-500 mr-1"></i><span class="font-semibold"> Gambar
                        Pendukung:</span> Relevan dan menarik.</li>
                <li><i class="fas fa-check-circle text-green-500 mr-1"></i><span class="font-semibold">
                        Kategorisasi:</span> Pilih kategori yang tepat.</li>
            </ul>
        </div>
        <div class="bg-gray-50 rounded-lg shadow p-5">
            <h3 class="font-semibold text-lg mb-3 flex items-center gap-2 text-blue-500"><i class="fas fa-keyboard"></i>
                Shortcut</h3>
            <div class="space-y-4">
                <div class="flex flex-col items-center border rounded-lg bg-white p-3">
                    <div><kbd class="px-2 py-1 bg-gray-200 rounded">Ctrl</kbd> + <kbd
                            class="px-2 py-1 bg-gray-200 rounded">S</kbd></div>
                    <div class="text-gray-500 text-xs mt-1">Simpan Draft</div>
                </div>
                <div class="flex flex-col items-center border rounded-lg bg-white p-3">
                    <div><kbd class="px-2 py-1 bg-gray-200 rounded">Ctrl</kbd> + <kbd
                            class="px-2 py-1 bg-gray-200 rounded">Enter</kbd></div>
                    <div class="text-gray-500 text-xs mt-1">Publikasi</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
@endpush

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const image = preview.querySelector('img');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            image.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        image.src = '#';
        preview.classList.add('hidden');
    }
}
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        document.querySelector('button[value="draft"]').click();
    }
    if (e.ctrlKey && e.key === 'Enter') {
        e.preventDefault();
        document.querySelector('button[value="publish"]').click();
    }
});
</script>
@endpush