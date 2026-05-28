<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Contact form submission
Route::post('/contact', [ContactController::class, 'send'])
    ->middleware(['throttle:5,1'])   // extra layer via Laravel middleware (6th+/min → 429)
    ->name('contact.send');

// Programs (placeholder routes for links in blade)
Route::get('/programs', fn () => view('programs.index'))->name('programs.index');
Route::get('/programs/{program:slug}', fn ($program) => view('programs.show', compact('program')))->name('programs.show');

// Gallery
Route::get('/gallery', fn () => view('gallery.index'))->name('gallery.index');

// Legal pages (minimal placeholders)
Route::get('/privacy-policy', fn () => view('legal.privacy'))->name('privacy-policy');
Route::get('/terms', fn () => view('legal.terms'))->name('terms');
