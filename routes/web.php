<?php

use App\Http\Controllers\AgriculturalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [AgriculturalController::class, 'index'])->name('home');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Agricultural routes (protected)
    Route::get('/guides', [AgriculturalController::class, 'guides'])->name('guides.index');
    Route::get('/guides/{id}', [AgriculturalController::class, 'showGuide'])->name('guides.show');
    Route::get('/crops', [AgriculturalController::class, 'crops'])->name('crops.index');
    Route::get('/crops/{id}', [AgriculturalController::class, 'showCrop'])->name('crops.show');
    Route::get('/pest-control', [AgriculturalController::class, 'pestControl'])->name('pest-control.index');
    Route::get('/pest-control/{id}', [AgriculturalController::class, 'showPestStrategy'])->name('pest-control.show');

    // Contact
    Route::get('/contact', [AgriculturalController::class, 'contact'])->name('contact');
    Route::post('/contact', [AgriculturalController::class, 'submitContact'])->name('contact.submit');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Settings
    Route::get('/settings', [AgriculturalController::class, 'settings'])->name('settings');
});

// Admin routes (optional - add middleware for admin role)
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AgriculturalController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::resource('/users', UserController::class);
    Route::resource('/guides', GuideController::class);
    Route::resource('/crops', CropController::class);
});

// Auth routes (automatically added by Laravel Breeze/Jetstream)
require __DIR__.'/auth.php';

// Catch-all route for SPA (optional)
Route::fallback(function () {
    return Inertia::render('NotFound');
});
