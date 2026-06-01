<?php
// routes/web.php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\GalleryController;
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

// ── Gallery ──────────────────────────────────────────────────────────────────
// Public gallery index (all categories, JS-filtered)
Route::get('/gallery', [App\Http\Controllers\GalleryController::class, 'index'])
    ->name('gallery.index');
 
// Public gallery detail — photos filtered by category slug
// The "all" slug shows every active photo.
// Place this AFTER all other /gallery/* routes to avoid conflicts.
Route::get('/gallery/{category}', [App\Http\Controllers\DetailGalleryController::class, 'index'])
    ->name('gallery.detail')
    ->where('category', '[^/]+');   // allow spaces encoded as %20
 
// ── Admin Gallery ─────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get   ('gallery',              [App\Http\Controllers\GalleryController::class, 'adminIndex'])->name('gallery.index');
    Route::get   ('gallery/create',       [App\Http\Controllers\GalleryController::class, 'create'])    ->name('gallery.create');
    Route::post  ('gallery',              [App\Http\Controllers\GalleryController::class, 'store'])     ->name('gallery.store');
    Route::get   ('gallery/{gallery}/edit',   [App\Http\Controllers\GalleryController::class, 'edit'])    ->name('gallery.edit');
    Route::put   ('gallery/{gallery}',        [App\Http\Controllers\GalleryController::class, 'update'])  ->name('gallery.update');
    Route::delete('gallery/{gallery}',        [App\Http\Controllers\GalleryController::class, 'destroy']) ->name('gallery.destroy');
    Route::patch ('gallery/{gallery}/toggle', [App\Http\Controllers\GalleryController::class, 'toggleActive'])->name('gallery.toggle');
    Route::post  ('gallery/reorder',          [App\Http\Controllers\GalleryController::class, 'reorder'])    ->name('gallery.reorder');
});
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
