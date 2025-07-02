<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;
use App\Repositories\BeritaRepository;
use App\Models\Komentar;

class AdminController extends Controller
{
    protected $statisticsService;
    protected $beritaRepository;

    public function __construct(StatisticsService $statisticsService, BeritaRepository $beritaRepository)
    {
        $this->statisticsService = $statisticsService;
        $this->beritaRepository = $beritaRepository;
    }

    public function index()
    {
        $stats = $this->statisticsService->getDashboardStats();
        $beritas = $this->beritaRepository->getLatestPaginated();
        $recentBerita = $this->beritaRepository->getRecent();
        $recentKomentar = Komentar::with(['user', 'berita'])->latest()->take(5)->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'beritas' => $beritas,
            'recentBerita' => $recentBerita,
            'recentKomentar' => $recentKomentar
        ]);
    }
}