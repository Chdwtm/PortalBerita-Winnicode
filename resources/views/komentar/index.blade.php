@extends('layouts.app')

@section('content')
<div class="content-section">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Kelola Komentar</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kelola Komentar</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('komentar.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari komentar...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="berita">
                        <option value="">Semua Berita</option>
                        @foreach($beritas as $berita)
                        <option value="{{ $berita->id }}" 
                            {{ request('berita') == $berita->id ? 'selected' : '' }}>
                            {{ Str::limit($berita->judul, 40) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="user">
                        <option value="">Semua Pengguna</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" 
                            {{ request('user') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
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

    <!-- Comments List -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @forelse($komentars as $komentar)
            <div class="comment-item border-bottom pb-4 mb-4">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <div class="avatar">
                            <i class="fas fa-user-circle fa-2x text-muted"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h6 class="mb-0">{{ $komentar->user->name }}</h6>
                                <small class="text-muted">
                                    {{ $komentar->created_at->format('d M Y H:i') }}
                                </small>
                            </div>
                            <div class="btn-group">
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="if(confirm('Apakah Anda yakin ingin menghapus komentar ini?')) { document.getElementById('delete-form-{{ $komentar->id }}').submit(); }"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $komentar->id }}" 
                                  action="{{ route('komentar.destroy', $komentar->id) }}" 
                                  method="POST" 
                                  style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                        <p class="mb-1">{{ $komentar->konten }}</p>
                        <div class="mt-2">
                            <a href="{{ route('berita.show', $komentar->berita->id) }}" class="text-decoration-none">
                                <i class="fas fa-newspaper me-1"></i>
                                {{ Str::limit($komentar->berita->judul, 100) }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="far fa-comments fa-3x text-muted mb-3"></i>
                <p class="text-muted mb-0">Belum ada komentar.</p>
            </div>
            @endforelse

            <!-- Pagination -->
            @if($komentars->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $komentars->firstItem() }} - {{ $komentars->lastItem() }} 
                    dari {{ $komentars->total() }} komentar
                </div>
                {{ $komentars->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>

@if(session('success'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fas fa-check-circle text-success me-2"></i>
            <strong class="me-auto">Sukses</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
// Auto hide toast after 3 seconds
document.addEventListener('DOMContentLoaded', function() {
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function(toastEl) {
        return new bootstrap.Toast(toastEl, {
            autohide: true,
            delay: 3000
        });
    });
});
</script>
@endpush
@endsection