@extends('layouts.app')

@section('content')
<div class="content-section">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('berita.show', $berita->id) }}">{{ Str::limit($berita->judul, 30) }}</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Berita</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="judul" class="form-label">Judul Berita</label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('judul') is-invalid @enderror" 
                                   id="judul" 
                                   name="judul" 
                                   value="{{ old('judul', $berita->judul) }}" 
                                   required>
                            @error('judul')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" 
                                    id="kategori_id" 
                                    name="kategori_id">
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" 
                                    {{ (old('kategori_id', $berita->kategori_id) == $kategori->id) ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="konten" class="form-label">Konten Berita</label>
                            <textarea class="form-control @error('konten') is-invalid @enderror" 
                                      id="konten" 
                                      name="konten" 
                                      rows="10" 
                                      required>{{ old('konten', $berita->konten) }}</textarea>
                            @error('konten')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="gambar" class="form-label">Gambar Berita</label>
                            @if($berita->gambar)
                            <div class="current-image mb-3">
                                <img src="{{ asset('storage/' . $berita->gambar) }}" 
                                     alt="Current Image" 
                                     class="img-thumbnail" 
                                     style="max-height: 200px;">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="remove_image" 
                                           name="remove_image" 
                                           value="1">
                                    <label class="form-check-label" for="remove_image">
                                        Hapus gambar saat ini
                                    </label>
                                </div>
                            </div>
                            @endif
                            <div class="input-group">
                                <input type="file" 
                                       class="form-control @error('gambar') is-invalid @enderror" 
                                       id="gambar" 
                                       name="gambar"
                                       accept="image/*"
                                       onchange="previewImage(this)">
                                @error('gambar')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div id="image-preview" class="mt-3 d-none">
                                <img src="#" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                            <small class="form-text text-muted">
                                Format yang didukung: JPG, JPEG, PNG. Maksimal 2MB.
                            </small>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="published" 
                                       name="published" 
                                       value="1" 
                                       {{ $berita->published ? 'checked' : '' }}>
                                <label class="form-check-label" for="published">
                                    Publikasikan berita
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                Jika tidak dicentang, berita akan disimpan sebagai draft.
                            </small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" 
                                    class="btn btn-light" 
                                    onclick="window.history.back()">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </button>
                            <div>
                                <button type="submit" 
                                        name="action" 
                                        value="draft" 
                                        class="btn btn-secondary me-2">
                                    <i class="fas fa-save me-2"></i>Simpan Draft
                                </button>
                                <button type="submit" 
                                        name="action" 
                                        value="publish" 
                                        class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Publikasikan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Berita</h5>
                </div>
                <div class="card-body">
                    <div class="info-list">
                        <div class="info-item d-flex justify-content-between mb-3">
                            <span class="text-muted">Status</span>
                            <span class="badge {{ $berita->published ? 'bg-success' : 'bg-warning' }}">
                                {{ $berita->published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                        <div class="info-item d-flex justify-content-between mb-3">
                            <span class="text-muted">Dibuat pada</span>
                            <span>{{ $berita->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="info-item d-flex justify-content-between mb-3">
                            <span class="text-muted">Terakhir diupdate</span>
                            <span>{{ $berita->updated_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="info-item d-flex justify-content-between mb-3">
                            <span class="text-muted">Total views</span>
                            <span>{{ $berita->views ?? 0 }}</span>
                        </div>
                        <div class="info-item d-flex justify-content-between">
                            <span class="text-muted">Total komentar</span>
                            <span>{{ $berita->komentars_count ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-keyboard me-2"></i>Shortcut</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-3 border rounded text-center">
                                <kbd>Ctrl</kbd> + <kbd>S</kbd>
                                <small class="d-block text-muted">Simpan Draft</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 border rounded text-center">
                                <kbd>Ctrl</kbd> + <kbd>Enter</kbd>
                                <small class="d-block text-muted">Publikasi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const image = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            image.src = e.target.result;
            preview.classList.remove('d-none');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        image.src = '#';
        preview.classList.add('d-none');
    }
}

// Keyboard shortcuts
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
@endsection