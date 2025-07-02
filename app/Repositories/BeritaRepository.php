<?php

namespace App\Repositories;

use App\Models\Berita;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BeritaRepository
{
    protected $model;
    protected $perPage = 10;

    public function __construct(Berita $berita)
    {
        $this->model = $berita;
    }

    public function getLatestPaginated(): LengthAwarePaginator
    {
        return $this->model
            ->with(['kategori', 'penulis', 'reactions'])
            ->latest()
            ->paginate($this->perPage);
    }

    public function getRecent(int $limit = 5): Collection
    {
        return $this->model
            ->with(['kategori', 'penulis'])
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getPopular(int $limit = 5): Collection
    {
        return $this->model
            ->with(['kategori', 'penulis'])
            ->orderBy('views', 'desc')
            ->take($limit)
            ->get();
    }

    public function getByKategori($kategoriId): LengthAwarePaginator
    {
        return $this->model
            ->with(['kategori', 'penulis'])
            ->where('kategori_id', $kategoriId)
            ->latest()
            ->paginate($this->perPage);
    }

    public function search(string $keyword): LengthAwarePaginator
    {
        return $this->model
            ->with(['kategori', 'penulis'])
            ->where('judul', 'LIKE', "%{$keyword}%")
            ->orWhere('konten', 'LIKE', "%{$keyword}%")
            ->latest()
            ->paginate($this->perPage);
    }

    public function create(array $data): Berita
    {
        return $this->model->create($data);
    }

    public function update(Berita $berita, array $data): bool
    {
        return $berita->update($data);
    }

    public function delete(Berita $berita): bool
    {
        return $berita->delete();
    }

    public function incrementViews(Berita $berita): void
    {
        $berita->increment('views');
        // Update juga ke berita_analytics
        $analytics = $berita->analytics()->first();
        if ($analytics) {
            $analytics->increment('views');
        } else {
            $berita->analytics()->create([
                'views' => 1
            ]);
        }
    }
}