<?php
// routes/web.php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

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
