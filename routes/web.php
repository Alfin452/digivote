<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// publik
use App\Http\Controllers\EventController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\WebhookController;

// admin event
use App\Http\Controllers\AdminEvent\QrLinkController;
use App\Http\Controllers\AdminEvent\AuthController as AdminEventAuthController;
use App\Http\Controllers\AdminEvent\DashboardController as AdminEventDashboardController;
use App\Http\Controllers\AdminEvent\TransactionController as AdminEventTransactionController;
use App\Http\Controllers\AdminEvent\CategoryController as AdminEventCategoryController;
use App\Http\Controllers\AdminEvent\VoteController as AdminEventVoteController;
use App\Http\Controllers\AdminEvent\LeaderboardController;


use App\Http\Controllers\Admin\AuthController as SuperAdminAuthController;
use App\Http\Controllers\Admin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\Admin\EventController as SuperAdminEventController;
use App\Http\Controllers\Admin\TransactionController as SuperAdminTransactionController;
use App\Http\Controllers\Admin\SettingController as SuperAdminSettingController;
use App\Http\Controllers\Admin\EventAdminController;

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

// Route Form Vote dan Submit Vote
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/vote/{slug}', [VoteController::class, 'create'])->name('vote.create');
    Route::post('/vote/{slug}', [VoteController::class, 'store'])->name('vote.store');
});

// webhook xendit
Route::middleware('throttle:300,1')->group(function () {
    Route::post('/webhook/xendit', [WebhookController::class, 'xendit']);
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

        Route::resource('categories', AdminEventCategoryController::class)->names('categories');
        Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
        Route::get('/leaderboard/create', [LeaderboardController::class, 'create'])->name('team.create');
        Route::post('/leaderboard', [LeaderboardController::class, 'store'])->name('team.store');
        Route::get('/leaderboard/{id}/edit', [LeaderboardController::class, 'edit'])->name('team.edit');
        Route::put('/leaderboard/{id}', [LeaderboardController::class, 'update'])->name('team.update');
        Route::delete('/leaderboard/{id}', [LeaderboardController::class, 'destroy'])->name('team.destroy');

        Route::get('/qr-links', [QrLinkController::class, 'index'])->name('qr-links');
        Route::get('/transactions', [AdminEventTransactionController::class, 'index'])->name('transactions');
        Route::get('/votes', [AdminEventVoteController::class, 'index'])->name('votes');

        Route::post('/logout', [AdminEventAuthController::class, 'logout'])->name('logout');
    });
});

// RUTE SUPER ADMIN (MASTER)
Route::prefix('admin')->name('admin.')->group(function () {

    // Route untuk guest (belum login)
    Route::middleware('guest:super_admin')->group(function () {
        Route::get('/login', [SuperAdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [SuperAdminAuthController::class, 'login'])->name('login.post');
    });

    // Route yang butuh login Super Admin
    Route::middleware('auth:super_admin')->group(function () {
        // 1. Dashboard
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

        // 2. Manajemen Event dan Akun Panitia (Penulisan dirapikan)
        Route::resource('events', SuperAdminEventController::class);
        Route::resource('event-admins', EventAdminController::class);
        Route::get('/transactions', [SuperAdminTransactionController::class, 'index'])->name('transactions.index');        // 3. Logout
        Route::get('/settings', [SuperAdminSettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SuperAdminSettingController::class, 'update'])->name('settings.update');
        Route::post('/logout', [SuperAdminAuthController::class, 'logout'])->name('logout');
    });
});

// halaman event publik
Route::get('/{slug}', [EventController::class, 'show'])->name('event.show');
