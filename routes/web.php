<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ActivityLogController,
    Admin\TrashController,
    Auth\LoginController,
    Auth\RegisterController,
    CommentController,
    DashboardController,
    EventController,
    FavoriteController,
    PlanetController,
    RatingController
};

// Guest
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Authenticated
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // PLANETS
    Route::middleware('role:admin')->group(function () {
        Route::get('/planets/create', [PlanetController::class, 'create'])->name('planets.create');
        Route::post('/planets', [PlanetController::class, 'store'])->name('planets.store');
        Route::get('/planets/{planet}/edit', [PlanetController::class, 'edit'])->name('planets.edit');
        Route::put('/planets/{planet}', [PlanetController::class, 'update'])->name('planets.update');
        Route::delete('/planets/{planet}', [PlanetController::class, 'destroy'])->name('planets.destroy');
        Route::post('/planets/{id}/restore', [PlanetController::class, 'restore'])->name('planets.restore');
        Route::delete('/planets/{id}/force-delete', [PlanetController::class, 'forceDelete'])->name('planets.force-delete');
    });

    Route::get('/planets', [PlanetController::class, 'index'])->name('planets.index');
    Route::get('/planets/{planet}', [PlanetController::class, 'show'])->name('planets.show');

    // EVENTS
    Route::middleware('role:admin')->group(function () {
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
        Route::post('/events/{id}/restore', [EventController::class, 'restore'])->name('events.restore');
        Route::delete('/events/{id}/force-delete', [EventController::class, 'forceDelete'])->name('events.force-delete');
    });

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

    // FAVORITES
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // COMMENTS
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    Route::middleware('role:admin')->group(function () {
        Route::post('/comments/{id}/restore', [CommentController::class, 'restore'])->name('comments.restore');
        Route::delete('/comments/{id}/force-delete', [CommentController::class, 'forceDelete'])->name('comments.force-delete');
    });

    // RATINGS
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');

    // ADMIN
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/activity-logs', [ActivityLogController::class, 'index'])->name('admin.activity-logs');
        Route::get('/admin/trash', [TrashController::class, 'index'])->name('admin.trash');
    });
});