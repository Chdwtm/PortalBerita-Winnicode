@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Tambah Berita Baru</h1>
            <p class="mb-0 text-gray-600">Buat artikel berita baru untuk dipublikasikan</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-primary">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.berita.index') }}" class="text-primary">Berita</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Berita</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h5 class="alert-heading d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Terjadi Kesalahan
                        </h5>
                        <ul class="list-unstyled mb-0">
                            @foreach($errors->all() as $error)
                            <li class="mb-1"><i class="fas fa-times mr-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Judul Berita -->
                                <div class="form-group">
                                    <label for="judul" class="font-weight-bold text-dark">
                                        Judul Berita <span class="text-danger">*</span>
                                    </label>
                <input type="text" 
                                           class="form-control form-control-lg @error('judul') is-invalid @enderror" 
                                           id="judul" 
                       name="judul" 
                       value="{{ old('judul') }}"
                                           placeholder="Masukkan judul berita"
                       required>
                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

                                <!-- Konten Berita -->
                                <div class="form-group">
                                    <label for="konten" class="font-weight-bold text-dark">
                                        Konten Berita <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('konten') is-invalid @enderror" 
                                              id="editor" 
                                              name="konten" 
                                              rows="12"
                                              placeholder="Tulis konten berita di sini..."
                                              required>{{ old('konten') }}</textarea>
                                    @error('konten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card bg-light">
                                    <div class="card-body">
            <!-- Kategori -->
                                        <div class="form-group">
                                            <label for="kategori_id" class="font-weight-bold text-dark">
                                                Kategori <span class="text-danger">*</span>
                                            </label>
                                            <select class="custom-select @error('kategori_id') is-invalid @enderror" 
                        id="kategori_id" 
                                                    name="kategori_id" 
                                                    required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Gambar -->
                                        <div class="form-group">
                                            <label for="gambar" class="font-weight-bold text-dark">
                                                Gambar Berita
                                            </label>
                                            <div class="custom-file">
                        <input type="file" 
                                                       class="custom-file-input @error('gambar') is-invalid @enderror" 
                                                       id="gambar" 
                               name="gambar" 
                               accept="image/*"
                               onchange="previewImage(event)">
                                                <label class="custom-file-label" for="gambar">Pilih gambar...</label>
                    </div>
                                            <small class="form-text text-muted">
                                                Format: JPG, PNG, GIF (Maks. 2MB)
                                            </small>
                @error('gambar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                                            <div id="imagePreview" class="mt-3 d-none">
                                                <img src="" class="img-thumbnail" id="preview">
            </div>
            </div>

                                        <hr>

                                        <!-- Tombol Submit -->
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save mr-2"></i>Simpan Berita
                </button>
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
</div>

@push('styles')
<style>
    /* Form Styles */
    .form-control {
        border: 1px solid #e3e6f0;
        border-radius: 0.35rem;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }
    .form-control-lg {
        font-size: 1.1rem;
    }
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    .custom-file-label {
        border: 1px solid #e3e6f0;
        padding: 0.75rem 1rem;
    }
    .custom-file-input:focus ~ .custom-file-label {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    /* Card Styles */
    .card {
        border: none;
        border-radius: 0.5rem;
    }
    .card-body {
        padding: 1.5rem;
    }
    .bg-light {
        background-color: #f8f9fc !important;
    }

    /* Alert Styles */
    .alert {
        border: none;
        border-radius: 0.5rem;
    }
    .alert-danger {
        background-color: #fee2e2;
        color: #991b1b;
    }
    .alert-danger .alert-heading {
        color: #991b1b;
        font-size: 1rem;
        font-weight: 600;
    }
    .alert-danger ul li {
        font-size: 0.9rem;
    }

    /* Button Styles */
    .btn {
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 0.35rem;
        transition: all 0.2s ease-in-out;
    }
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
        transform: translateY(-1px);
    }
    .btn-secondary {
        background-color: #858796;
        border-color: #858796;
    }
    .btn-secondary:hover {
        background-color: #717384;
        border-color: #6b6d7d;
        transform: translateY(-1px);
    }

    /* Breadcrumb Styles */
    .breadcrumb {
        padding: 0;
        margin: 0;
        font-size: 0.9rem;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        font-size: 1.1rem;
        line-height: 1;
        color: #858796;
    }
    .breadcrumb-item.active {
        color: #858796;
    }

    /* Image Preview */
    #imagePreview img {
        max-height: 200px;
        width: auto;
        border-radius: 0.35rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
<script>
    // Initialize CKEditor
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'mediaEmbed', '|', 'undo', 'redo'],
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                ]
            }
        })
        .catch(error => {
            console.error(error);
        });

    // Image Preview
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('d-none');
        }

        if (file) {
        reader.readAsDataURL(file);
            document.querySelector('.custom-file-label').textContent = file.name;
        }
    }

    // Form Validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endpush
@endsection