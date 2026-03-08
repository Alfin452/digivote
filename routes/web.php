<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\WebhookController;

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

//halaman event publik
Route::get('/{slug}', [EventController::class, 'show'])->name('event.show');
