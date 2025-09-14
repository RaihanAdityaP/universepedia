<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlanetController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;

// Redirect root to welcome
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Password Reset Routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Dashboard with auto-seeding
    Route::get('/dashboard', function() {
        // Check and seed if needed
        if (\App\Models\Planet::count() === 0 || \App\Models\Event::count() === 0) {
            \Artisan::call('universepedia:seed');
        }
        return app(\App\Http\Controllers\DashboardController::class)->index();
    })->name('dashboard');
    
    // Profile - accessible by all authenticated users
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Planets - Read-only for users, full access for admins
    Route::get('/planets', [PlanetController::class, 'index'])->name('planets.index');
    
    // Admin-only routes (Planet management first, so create/edit tidak ketabrak show)
    Route::middleware('admin')->group(function () {
        Route::get('/planets/create', [PlanetController::class, 'create'])->name('planets.create');
        Route::post('/planets', [PlanetController::class, 'store'])->name('planets.store');
        Route::get('/planets/{planet}/edit', [PlanetController::class, 'edit'])->name('planets.edit');
        Route::put('/planets/{planet}', [PlanetController::class, 'update'])->name('planets.update');
        Route::delete('/planets/{planet}', [PlanetController::class, 'destroy'])->name('planets.destroy');
    });
    Route::get('/planets/{planet}', [PlanetController::class, 'show'])->name('planets.show');
    
    // Events - Read-only for users, full access for admins
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    
    Route::middleware('admin')->group(function () {
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    
    // Reports - accessible by all authenticated users
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    
    // Admin-only routes
    Route::middleware('admin')->group(function () {
        // User management
        Route::resource('users', UserController::class);
    });
});