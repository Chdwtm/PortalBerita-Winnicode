@extends('layouts.app')

@section('content')
<div class="content-section">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Kelola Berita</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kelola Berita</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('berita.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Tulis Berita Baru
        </a>
    </div>

    <!-- Filter & Search Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('berita.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari berita...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" 
                            {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>
                            Published
                        </option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Berita List -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" style="width: 50px;">No</th>
                            <th scope="col">Judul</th>
                            <th scope="col" style="width: 150px;">Kategori</th>
                            <th scope="col" style="width: 120px;">Status</th>
                            <th scope="col" style="width: 150px;">Tanggal</th>
                            <th scope="col" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($beritas as $index => $berita)
                        <tr>
                            <td>{{ $beritas->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($berita->gambar)
                                    <img src="{{ asset('storage/' . $berita->gambar) }}" 
                                         alt="{{ $berita->judul }}"
                                         class="rounded me-3"
                                         style="width: 48px; height: 48px; object-fit: cover;">
                                    @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                         style="width: 48px; height: 48px;">
                                        <i class="fas fa-newspaper text-muted"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ Str::limit($berita->judul, 50) }}</h6>
                                        <div class="d-flex align-items-center small text-muted">
                                            <span class="me-2">
                                                <i class="far fa-eye me-1"></i>{{ $berita->views ?? 0 }}
                                            </span>
                                            <span>
                                                <i class="far fa-comment me-1"></i>{{ $berita->komentars_count ?? 0 }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary rounded-pill">
                                    {{ optional($berita->kategori)->nama ?? 'Umum' }}
                                </span>
                            </td>
                            <td>
                                @if($berita->published)
                                <span class="badge bg-success">Published</span>
                                @else
                                <span class="badge bg-warning">Draft</span>
                                @endif
                            </td>
                            <td>
                                <div class="small">
                                    <div>Dibuat: {{ $berita->created_at->format('d M Y') }}</div>
                                    <div class="text-muted">Update: {{ $berita->updated_at->format('d M Y') }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('berita.show', $berita->id) }}" 
                                       class="btn btn-sm btn-outline-primary"
                                       data-bs-toggle="tooltip"
                                       title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('berita.edit', $berita->id) }}" 
                                       class="btn btn-sm btn-outline-warning"
                                       data-bs-toggle="tooltip"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="tooltip"
                                            title="Hapus"
                                            onclick="if(confirm('Apakah Anda yakin ingin menghapus berita ini?')) { document.getElementById('delete-form-{{ $berita->id }}').submit(); }">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $berita->id }}" 
                                      action="{{ route('berita.destroy', $berita->id) }}" 
                                      method="POST" 
                                      style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-newspaper fa-3x mb-3"></i>
                                    <p>Belum ada berita yang dibuat.</p>
                                    <a href="{{ route('berita.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus-circle me-2"></i>Tulis Berita Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($beritas->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
            Menampilkan {{ $beritas->firstItem() }} - {{ $beritas->lastItem() }} dari {{ $beritas->total() }} berita
        </div>
        {{ $beritas->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@push('scripts')
<script>
// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});
</script>
@endpush
@endsection