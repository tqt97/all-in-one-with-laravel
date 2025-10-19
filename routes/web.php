<?php

use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Auth\TwoFactorVerifyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', '2fa'])->name('dashboard');

Route::middleware(['auth', '2fa'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/profile/two-factor/enable', [TwoFactorController::class, 'enable'])->name('two-factor.enable');
    Route::post('/profile/two-factor/disable', [TwoFactorController::class, 'disable'])->name('two-factor.disable');

    Route::middleware('throttle:5,1')->group(function () {
        Route::get('/verify-two-factor', [TwoFactorVerifyController::class, 'show'])->name('two-factor.verify.form');
        Route::post('/verify-two-factor', [TwoFactorVerifyController::class, 'verify'])->name('two-factor.verify');
    });
});

require __DIR__.'/auth.php';
