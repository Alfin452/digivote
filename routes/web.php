<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\AdminEvent\QrLinkController;
use App\Http\Controllers\AdminEvent\AuthController as AdminEventAuthController;
use App\Http\Controllers\AdminEvent\DashboardController as AdminEventDashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

//Route Form Vote dan Submit Vote
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/vote/{slug}', [VoteController::class, 'create'])->name('vote.create');
    Route::post('/vote/{slug}', [VoteController::class, 'store'])->name('vote.store');
});

//webhook xendit
Route::middleware('throttle:300,1')->group(function () {
    Route::post('/webhook/xendit', [WebhookController::class, 'xendit']); // [cite: 386]
});

// RUTE ADMIN EVENT
Route::prefix('admin-event')->name('admin-event.')->group(function () {
    // Route untuk guest (belum login)
    Route::middleware('guest:event_admin')->group(function () {
        Route::get('/login', [AdminEventAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminEventAuthController::class, 'login'])->name('login.post');
    });

    // Route yang butuh login (dilindungi middleware auth:event_admin)
    Route::middleware('auth:event_admin')->group(function () {
        Route::get('/overview', [AdminEventDashboardController::class, 'index'])->name('dashboard');
        Route::get('/qr-links', [QrLinkController::class, 'index'])->name('qr-links'); 
        Route::post('/logout', [AdminEventAuthController::class, 'logout'])->name('logout');
    });
});

//halaman event publik
Route::get('/{slug}', [EventController::class, 'show'])->name('event.show');
