<?php

use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\PublicScanningController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Legal Pages
|--------------------------------------------------------------------------
*/

Route::get('/integritetspolicy', function () {
    return view('legal.privacy');
})->name('legal.privacy');

Route::get('/anvandarvillkor', function () {
    return view('legal.terms');
})->name('legal.terms');

Route::get('/cookie-policy', function () {
    return view('legal.cookies');
})->name('legal.cookies');

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
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Facilities
    Route::get('/facilities', \App\Livewire\Facilities\Index::class)->name('facilities.index');
    Route::get('/facilities/create', \App\Livewire\Facilities\CreateEdit::class)->name('facilities.create');
    Route::get('/facilities/{facility}/edit', \App\Livewire\Facilities\CreateEdit::class)->name('facilities.edit');

    // Stations
    Route::get('/stations', \App\Livewire\Stations\Index::class)->name('stations.index');
    Route::get('/stations/create', \App\Livewire\Stations\CreateEdit::class)->name('stations.create');
    Route::get('/stations/{station}/edit', \App\Livewire\Stations\CreateEdit::class)->name('stations.edit');
    Route::get('/stations/{station}/qr', \App\Livewire\Stations\QrCode::class)->name('stations.qr');
});

/*
|--------------------------------------------------------------------------
| Public Scanning Routes
|--------------------------------------------------------------------------
*/

Route::get('/s/{uuid}', [PublicScanningController::class, 'show'])->name('public.scan');
Route::get('/s/{uuid}/qr', [PublicScanningController::class, 'qrCode'])->name('public.scan.qr');
