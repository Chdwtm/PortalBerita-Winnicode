<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BeritaReactionController;
use App\Http\Controllers\DataAnalyticsController;
use App\Http\Controllers\TechnicalTermController;
use App\Http\Controllers\Admin\AnalyticsController;

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');

// **Halaman Utama (Berita Lokal + API)**
Route::get('/', [BeritaController::class, 'index'])->name('home');

// **Fitur Pencarian Berita**
Route::get('/search', [BeritaController::class, 'search'])->name('berita.search');

// **Login & Register**
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// **Halaman Detail Berita Nasional & Internasional**
Route::get('/berita/{berita}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/berita-internasional/{id}', [BeritaController::class, 'showInternationalNews'])->name('berita.international.show');

// Halaman detail berita nasional dari API
Route::get('/berita-nasional/{index}', [BeritaController::class, 'showNasionalNews'])->name('berita.nasional.show');

// **Fitur Like & Dislike (perlu login)**
Route::middleware(['auth', 'throttle.reactions'])->group(function () {
    Route::post('/berita/{berita}/reaction', [BeritaReactionController::class, 'react'])->name('berita.reaction');
    Route::delete('/berita/{berita}/reaction', [BeritaReactionController::class, 'remove'])->name('berita.reaction.remove');
});

// **Halaman Kategori Berita**
Route::get('/kategori/{kategori}', [BeritaController::class, 'kategori'])->name('berita.kategori');

// **Dashboard User (Setelah Login)**
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [BeritaController::class, 'dashboard'])->name('dashboard');
});

// **Dashboard Admin & CRUD Berita**
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // **CRUD Berita**
    Route::resource('/admin/berita', BeritaController::class)->parameters([
        'berita' => 'berita'
    ])->names([
        'index'   => 'admin.berita.index',
        'create'  => 'admin.berita.create',
        'store'   => 'admin.berita.store',
        'show'    => 'admin.berita.show',
        'edit'    => 'admin.berita.edit',
        'update'  => 'admin.berita.update',
        'destroy' => 'admin.berita.destroy',
    ]);

    // **CRUD Kategori oleh Admin**
    Route::resource('/admin/kategori', KategoriController::class)->names([
        'index' => 'admin.kategori.index',
        'create' => 'admin.kategori.create',
        'store' => 'admin.kategori.store',
        'edit' => 'admin.kategori.edit',
        'update' => 'admin.kategori.update',
        'destroy' => 'admin.kategori.destroy'
    ]);

    // **Manajemen Komentar oleh Admin**
    Route::resource('/admin/komentar', KomentarController::class)->only(['index', 'show', 'destroy'])->names([
        'index' => 'admin.komentar.index',
        'show' => 'admin.komentar.show',
        'destroy' => 'admin.komentar.destroy'
    ]);

    // **Manajemen Pengguna oleh Admin**
    Route::resource('/admin/users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy'
    ]);

    // Analytics Dashboard
    Route::get('/admin/analytics', [AnalyticsController::class, 'index'])->name('admin.analytics.index');
    Route::post('/admin/berita/{berita}/analyze', [DataAnalyticsController::class, 'analyzeContent'])->name('admin.berita.analyze');
});

// **Fitur Komentar di Berita**
Route::middleware(['auth', 'throttle.comments'])->group(function () {
    Route::post('/berita/{berita}/komentar', [KomentarController::class, 'store'])->name('berita.komentar');
    Route::delete('/berita/{berita}/komentar/{komentar}', [KomentarController::class, 'destroy'])->name('berita.komentar.destroy');
});

Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');

// English for Computer Routes
Route::prefix('glossary')->group(function () {
    Route::get('/', [TechnicalTermController::class, 'index'])->name('glossary.index');
    Route::get('/search', [TechnicalTermController::class, 'search'])->name('glossary.search');
    Route::get('/{term}', [TechnicalTermController::class, 'show'])->name('glossary.show');
    
    // Admin only routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/create', [TechnicalTermController::class, 'create'])->name('glossary.create');
        Route::post('/', [TechnicalTermController::class, 'store'])->name('glossary.store');
        Route::get('/{term}/edit', [TechnicalTermController::class, 'edit'])->name('glossary.edit');
        Route::put('/{term}', [TechnicalTermController::class, 'update'])->name('glossary.update');
        Route::delete('/{term}', [TechnicalTermController::class, 'destroy'])->name('glossary.destroy');
    });
});

// Language Switch Route
Route::get('/language/{language}', function ($language) {
    session(['locale' => $language]);
    return redirect()->back();
})->name('language.switch');