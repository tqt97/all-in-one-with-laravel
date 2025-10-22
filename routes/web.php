<?php

use App\Http\Controllers\Auth\MagicLinkController;
use App\Http\Controllers\Auth\SocialiteController;
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
        Route::get('/verify-two-factor/otp', [TwoFactorVerifyController::class, 'showOtpForm'])->name('two-factor.verify.form.otp');
        Route::get('/verify-two-factor/recovery', [TwoFactorVerifyController::class, 'showRecoveryForm'])->name('two-factor.verify.form.recovery');
        Route::post('/verify-two-factor/otp', [TwoFactorVerifyController::class, 'verifyOtp'])->name('two-factor.verify.otp');
        Route::post('/verify-two-factor/recovery', [TwoFactorVerifyController::class, 'verifyRecovery'])->name('two-factor.verify.recovery');
    });
});

// Socialite Routes
Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('auth.provider.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('auth.provider.callback');

// Magic link signin
Route::middleware(['guest', 'throttle:10,1'])->group(function () {
    Route::get('/magic', [MagicLinkController::class, 'showForm'])->name('magic.form');
    Route::post('/magic', [MagicLinkController::class, 'sendLink'])->name('magic.send');
    Route::get('/magic/verify', [MagicLinkController::class, 'verify'])->name('magic.verify');
});

require __DIR__.'/auth.php';
