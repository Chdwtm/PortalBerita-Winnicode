@extends('layouts.app')

@section('content')
<div class="content-section">
    <!-- Welcome Section -->
    <div class="bg-primary text-white rounded-4 p-4 mb-5 shadow-sm">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-2"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h2>
                <p class="mb-0 opacity-75">Selamat datang kembali, {{ Auth::user()->name }}!</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('berita.create') }}" class="btn btn-light">
                    <i class="fas fa-plus-circle me-2"></i>Tulis Berita Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 bg-info bg-opacity-10 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-info text-white p-3 me-3">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div>
                            <h6 class="card-title mb-0">Total Berita</h6>
                            <h3 class="mb-0">{{ $beritas->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-success bg-opacity-10 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-success text-white p-3 me-3">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div>
                            <h6 class="card-title mb-0">Total Komentar</h6>
                            <h3 class="mb-0">{{ $beritas->sum('komentars_count') ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-warning bg-opacity-10 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-warning text-white p-3 me-3">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div>
                            <h6 class="card-title mb-0">Total Views</h6>
                            <h3 class="mb-0">{{ $beritas->sum('views') ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Berita Terbaru -->
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Berita Terbaru</h5>
                <a href="{{ route('berita.index') }}" class="btn btn-link text-decoration-none">
                    Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">Judul</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($beritas->take(5) as $berita)
                        <tr>
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
                                        <small class="text-muted">
                                            <i class="far fa-comment me-1"></i>{{ $berita->komentars_count ?? 0 }}
                                            <i class="far fa-eye ms-2 me-1"></i>{{ $berita->views ?? 0 }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary rounded-pill">
                                    {{ optional($berita->kategori)->nama ?? 'Umum' }}
                                </span>
                            </td>
                            <td>{{ $berita->created_at->format('d M Y') }}</td>
                            <td>
                                @if($berita->published)
                                <span class="badge bg-success">Published</span>
                                @else
                                <span class="badge bg-warning">Draft</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('berita.show', $berita->id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('berita.edit', $berita->id) }}" 
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger" 
                                            onclick="if(confirm('Apakah Anda yakin ingin menghapus berita ini?')) { document.getElementById('delete-form-{{ $berita->id }}').submit(); }">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $berita->id }}" 
                                          action="{{ route('berita.destroy', $berita->id) }}" 
                                          method="POST" 
                                          style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
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

    <!-- Aktivitas Terbaru -->
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-comments me-2"></i>Komentar Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($beritas->flatMap->komentars->count() > 0)
                        @foreach($beritas->flatMap->komentars->take(5) as $komentar)
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <div class="avatar">
                                    <i class="fas fa-user-circle fa-2x text-muted"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">{{ $komentar->user->name }}</h6>
                                    <small class="text-muted">{{ $komentar->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1">{{ Str::limit($komentar->konten, 100) }}</p>
                                <small class="text-muted">
                                    pada berita "{{ Str::limit($komentar->berita->judul, 50) }}"
                                </small>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="far fa-comments fa-3x mb-3"></i>
                        <p>Belum ada komentar.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Berita Populer</h5>
                </div>
                <div class="card-body">
                    @if($beritas->count() > 0)
                        @foreach($beritas->sortByDesc('views')->take(5) as $berita)
                        <div class="d-flex align-items-center mb-3">
                            @if($berita->gambar)
                            <img src="{{ asset('storage/' . $berita->gambar) }}" 
                                 alt="{{ $berita->judul }}"
                                 class="rounded me-3"
                                 style="width: 64px; height: 64px; object-fit: cover;">
                            @else
                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                 style="width: 64px; height: 64px;">
                                <i class="fas fa-newspaper text-muted"></i>
                            </div>
                            @endif
                            <div>
                                <h6 class="mb-1">{{ Str::limit($berita->judul, 50) }}</h6>
                                <div class="d-flex align-items-center">
                                    <span class="me-3">
                                        <i class="far fa-eye text-muted"></i>
                                        <small class="ms-1">{{ $berita->views ?? 0 }} views</small>
                                    </span>
                                    <span>
                                        <i class="far fa-comment text-muted"></i>
                                        <small class="ms-1">{{ $berita->komentars_count ?? 0 }} komentar</small>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-chart-line fa-3x mb-3"></i>
                        <p>Belum ada data berita populer.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection