<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Komentar;
use App\Services\NewsApiService;
use App\Services\StatisticsService;
use App\Services\BeritaNasionalApiService;
use App\Repositories\BeritaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    protected $newsApiService;
    protected $beritaRepository;
    protected $statisticsService;
    protected $beritaNasionalApiService;

    public function __construct(
        NewsApiService $newsApiService, 
        BeritaRepository $beritaRepository,
        StatisticsService $statisticsService,
        BeritaNasionalApiService $beritaNasionalApiService
    ) {
        $this->newsApiService = $newsApiService;
        $this->beritaRepository = $beritaRepository;
        $this->statisticsService = $statisticsService;
        $this->beritaNasionalApiService = $beritaNasionalApiService;
    }

    // **Menampilkan berita di halaman utama (Lokal + API)**
    public function index()
    {
        if (request()->is('admin/*')) {
            $beritas = Berita::with('kategori')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('admin.berita.index', compact('beritas'));
        }

        $beritas = $this->beritaRepository->getLatestPaginated();
        $newsFromAPI = $this->newsApiService->getTopHeadlines();
        $beritaNasional = $this->beritaNasionalApiService->getBeritaNasional(50); // Ambil 50 berita nasional
        $kategoris = Kategori::all();

        // Gabungkan berita lokal dan nasional untuk berita terbaru
        $beritaTerbaruGabungan = collect($beritas->items());
        foreach ($beritaNasional as $nasional) {
            // Tandai sebagai nasional agar di view bisa dibedakan jika perlu
            $nasional['is_nasional'] = true;
            $beritaTerbaruGabungan->push($nasional);
        }
        // Urutkan berdasarkan tanggal jika data nasional punya 'pubDate' atau 'created_at'
        $beritaTerbaruGabungan = $beritaTerbaruGabungan->sortByDesc(function($item) {
            return $item['created_at'] ?? $item['pubDate'] ?? null;
        });

        return view('home', [
            'beritas' => $beritas,
            'newsFromAPI' => $newsFromAPI,
            'beritaNasional' => $beritaNasional,
            'kategoris' => $kategoris,
            'beritaTerbaruGabungan' => $beritaTerbaruGabungan,
        ]);
    }

    // **Menampilkan berita di dashboard pengguna (Populer, Terbaru, API)**
    public function dashboard()
    {
        $beritas = $this->beritaRepository->getLatestPaginated() ?? collect();
        $beritaPopuler = $this->beritaRepository->getPopular();
        $newsFromAPI = $this->newsApiService->getTopHeadlines();
        $beritaNasional = $this->beritaNasionalApiService->getBeritaNasional() ?? [];

        // Gabungkan berita lokal dan nasional (array)
        $beritaTerbaruGabungan = collect($beritas ?? [])->map(function($item) {
            if (is_object($item) && method_exists($item, 'toArray')) {
                $arr = $item->toArray();
            } elseif (is_array($item)) {
                $arr = $item;
            } else {
                $arr = (array) $item;
            }
            $arr['is_nasional'] = false;
            return $arr;
        })->merge(
            collect($beritaNasional ?? [])->map(function($item) {
                $item['is_nasional'] = true;
                return $item;
            })
        )->values();

        return view('home', compact('beritas', 'beritaPopuler', 'newsFromAPI', 'beritaNasional', 'beritaTerbaruGabungan'));
    }

    // **Menampilkan berita di dashboard admin**
    public function adminIndex()
    {
        $beritas = $this->beritaRepository->getLatestPaginated();
        $stats = $this->statisticsService->getDashboardStats();
        $recentBerita = $this->beritaRepository->getRecent();
        $recentKomentar = Komentar::with(['user', 'berita'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('beritas', 'stats', 'recentBerita', 'recentKomentar'));
    }

    // **Menampilkan berita berdasarkan kategori**
    public function kategori(Kategori $kategori)
    {
        $beritas = $this->beritaRepository->getByKategori($kategori->id);
        return view('berita.kategori', compact('beritas', 'kategori'));
    }

    // **Menampilkan berita secara lengkap & komentar**
    public function show(Berita $berita)
    {
        $this->beritaRepository->incrementViews($berita);
        $komentars = $berita->komentars()->latest()->get();
        $berita->load('reactions'); // Eager load reactions for performance
        return view('berita.show', compact('berita', 'komentars'));
    }

    public function showInternationalNews($id)
    {
        // Ambil data berita dari News API berdasarkan ID
        $newsFromAPI = $this->newsApiService->getTopHeadlines();
        $selectedNews = $newsFromAPI[$id] ?? null;

        if (!$selectedNews) {
            return redirect()->route('home')->with('error', 'Berita tidak ditemukan.');
        }

        return view('berita.show_international', compact('selectedNews'));
    }

    public function showNasionalNews($index)
    {
        $beritaNasional = $this->beritaNasionalApiService->getBeritaNasional(20); // Ambil lebih banyak agar index aman
        $selectedNews = $beritaNasional[$index] ?? null;
        if (!$selectedNews) {
            return redirect()->route('home')->with('error', 'Berita tidak ditemukan.');
        }
        return view('berita.show_international', [
            'selectedNews' => [
                'title' => $selectedNews['title'] ?? '-',
                'source' => ['name' => parse_url($selectedNews['link'] ?? '', PHP_URL_HOST)],
                'publishedAt' => $selectedNews['isoDate'] ?? now(),
                'urlToImage' => $selectedNews['image']['large'] ?? null,
                'content' => $selectedNews['contentSnippet'] ?? null,
                'original_url' => $selectedNews['link'] ?? null,
            ]
        ]);
    }

    // **Form tambah berita**
    public function create()
    {
        $kategoris = Kategori::all();
        return view('berita.create', compact('kategoris')); // Changed from admin.berita.create
    }

    // **Menyimpan berita yang ditambahkan admin**
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
        ]);

        $data = $request->only(['judul', 'kategori_id', 'konten']);
        $data['user_id'] = auth()->id();
        $data['penulis_id'] = auth()->id();
        
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $filename = Str::slug($request->judul) . '-' . time() . '.' . $gambar->getClientOriginalExtension();
            $data['gambar'] = $gambar->storeAs('berita', $filename, 'public');
        }

        // $data['konten'] = Purifier::clean($request->konten);
        // Alternatif: hanya izinkan tag HTML tertentu, misal <b>, <i>, <ul>, <ol>, <li>, <p>, <br>
        $data['konten'] = strip_tags($request->konten, '<b><i><ul><ol><li><p><br>');

        $this->beritaRepository->create($data);

        return redirect()->route('admin.dashboard')->with('success', 'Berita berhasil ditambahkan!');
    }

    // **Menampilkan form edit berita**
    public function edit(Berita $berita)
    {
        $kategoris = Kategori::all();
        return view('admin.berita.edit', compact('berita', 'kategoris'));
    }

    // **Menyimpan perubahan berita**
    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['judul', 'kategori_id', 'konten']);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::delete('public/' . $berita->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $this->beritaRepository->update($berita, $data);

        return redirect()->route('admin.dashboard')->with('success', 'Berita berhasil diperbarui!');
    }

    // **Menghapus berita**
    public function destroy(Berita $berita)
    {
        if ($berita->gambar) {
            Storage::delete('public/' . $berita->gambar);
        }
        
        $this->beritaRepository->delete($berita);

        return redirect()->route('admin.dashboard')->with('success', 'Berita berhasil dihapus!');
    }

    // **Menambahkan komentar ke berita**
    public function tambahKomentar(Request $request, Berita $berita)
    {
        $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        Komentar::create([
            'berita_id' => $berita->id,
            'user_id' => auth()->id(),
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    // **Fitur Pencarian Berita**
    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $beritas = $this->beritaRepository->search($keyword);
        $beritaNasional = $this->beritaNasionalApiService->getBeritaNasional(30); // Ambil 30 berita nasional dari API

        // Filter berita nasional yang cocok dengan keyword (judul/konten)
        $beritaNasionalFiltered = collect($beritaNasional)->filter(function($item) use ($keyword) {
            $judul = strtolower($item['title'] ?? '');
            $desc = strtolower($item['description'] ?? '');
            $keyword = strtolower($keyword);
            return str_contains($judul, $keyword) || str_contains($desc, $keyword);
        })->map(function($item) {
            $item['is_nasional'] = true;
            return $item;
        });

        // Gabungkan hasil lokal (paginator) dan nasional (collection)
        $beritaGabungan = collect($beritas->items())->map(function($item) {
            $arr = is_object($item) && method_exists($item, 'toArray') ? $item->toArray() : (array) $item;
            $arr['is_nasional'] = false;
            return $arr;
        })->merge($beritaNasionalFiltered)->values();

        // Untuk pagination manual, tetap kirim $beritas untuk paginasi lokal, dan $beritaGabungan untuk gabungan
        return view('berita.search', [
            'beritas' => $beritas,
            'beritaGabungan' => $beritaGabungan,
            'keyword' => $keyword
        ]);
    }
}