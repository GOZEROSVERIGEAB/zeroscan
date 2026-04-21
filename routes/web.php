<?php

use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\PublicScanningController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| OTP Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [OtpController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [OtpController::class, 'sendOtp'])->name('otp.send');
    Route::get('/login/verify/{user}', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');
    Route::post('/login/verify/{user}', [OtpController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/login/resend/{user}', [OtpController::class, 'resendOtp'])->name('otp.resend');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [OtpController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Public Scanning Routes
|--------------------------------------------------------------------------
*/

Route::get('/s/{uuid}', [PublicScanningController::class, 'show'])->name('public.scan');
Route::get('/s/{uuid}/qr', [PublicScanningController::class, 'qrCode'])->name('public.scan.qr');
