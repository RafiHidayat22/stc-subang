<?php
// routes/web.php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\ArticleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ── Home ──────────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ── About ─────────────────────────────────────────────────────────────────
Route::get('/about', [AboutController::class, 'index'])->name('about');

// ── Contact ───────────────────────────────────────────────────────────────
Route::post('/contact', [ContactController::class, 'send'])
    ->middleware(['throttle:5,1'])
    ->name('contact.send');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
// ── Programs ──────────────────────────────────────────────────────────────
Route::prefix('programs')->name('programs.')->group(function () {

    // Index: all programs / category overview
    Route::get('/', [ProgramController::class, 'index'])->name('index');

    // Category page: /programs/category/{slug}
    Route::get('/category/{category:slug}', [ProgramController::class, 'category'])->name('category');

    // Detail page: /programs/{slug}
    Route::get('/{program:slug}', [ProgramController::class, 'show'])->name('show');
});

// ── Gallery ───────────────────────────────────────────────────────────────
Route::get('/gallery', fn () => view('gallery.index'))->name('gallery.index');

// ── Legal ─────────────────────────────────────────────────────────────────
Route::get('/privacy-policy', fn () => view('legal.privacy'))->name('privacy-policy');
Route::get('/terms', fn () => view('legal.terms'))->name('terms');

// ── Certification ──────────────────────────────────────────────────────────
Route::prefix('certification')->name('certification.')->group(function () {
 
    // Index: overview semua kategori sertifikasi
    // URL: /certification
    Route::get('/', [CertificationController::class, 'index'])->name('index');
 
    // Category page: daftar item per kategori
    // URL: /certification/category/{slug}
    Route::get('/category/{category:slug}', [CertificationController::class, 'category'])->name('category');
 
    // Detail satu item sertifikasi
    // URL: /certification/{slug}
    Route::get('/{certificationItem:slug}', [CertificationController::class, 'show'])->name('show');
});

//Articles
Route::prefix('articles')->name('articles.')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('index');
    Route::get('/{article:slug}', [ArticleController::class, 'show'])->name('show');
});
