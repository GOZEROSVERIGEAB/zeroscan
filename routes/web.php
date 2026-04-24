<?php

use App\Http\Controllers\Auth\AdminOtpController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\PublicScanningController;
use App\Http\Controllers\Reports\ReportExportController;
use App\Livewire\Admin\Customers\CreateWizard;
use App\Livewire\Admin\Customers\Edit;
use App\Livewire\Admin\Customers\Index;
use App\Livewire\Admin\Customers\Show;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Facilities\CreateEdit;
use App\Livewire\Reports\CsrdReport;
use App\Livewire\Reports\EnvironmentImpact;
use App\Livewire\Reports\ExportCenter;
use App\Livewire\Reports\InventoryAnalytics;
use App\Livewire\Reports\Overview;
use App\Livewire\Stations\QrCode;
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
])->prefix('dashboard')->group(function () {
    // Dashboard
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Facilities
    Route::get('/facilities', fn () => view('facilities'))->name('facilities.index');
    Route::get('/facilities/create', CreateEdit::class)->name('facilities.create');
    Route::get('/facilities/{facility}/edit', CreateEdit::class)->name('facilities.edit');

    // Stations
    Route::get('/stations', fn () => view('stations'))->name('stations.index');
    Route::get('/stations/create', App\Livewire\Stations\CreateEdit::class)->name('stations.create');
    Route::get('/stations/{station}/edit', App\Livewire\Stations\CreateEdit::class)->name('stations.edit');
    Route::get('/stations/{station}/qr', QrCode::class)->name('stations.qr');

    // Reports
    Route::get('/reports', Overview::class)->name('reports.index');
    Route::get('/reports/environment', EnvironmentImpact::class)->name('reports.environment');
    Route::get('/reports/csrd', CsrdReport::class)->name('reports.csrd');
    Route::get('/reports/inventory', InventoryAnalytics::class)->name('reports.inventory');
    Route::get('/reports/exports', ExportCenter::class)->name('reports.exports');
    Route::get('/reports/export/{type}/{format}', [ReportExportController::class, 'export'])->name('reports.export');
});

/*
|--------------------------------------------------------------------------
| Public Scanning Routes
|--------------------------------------------------------------------------
*/

Route::get('/s/{uuid}', [PublicScanningController::class, 'show'])->name('public.scan');
Route::get('/s/{uuid}/qr', [PublicScanningController::class, 'qrCode'])->name('public.scan.qr');

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    // Admin OTP Authentication (guest)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminOtpController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [AdminOtpController::class, 'sendOtp'])->name('admin.otp.send');
        Route::get('/login/verify/{user}', [AdminOtpController::class, 'showVerifyForm'])->name('admin.otp.verify.form');
        Route::post('/login/verify/{user}', [AdminOtpController::class, 'verifyOtp'])->name('admin.otp.verify');
        Route::post('/login/resend/{user}', [AdminOtpController::class, 'resendOtp'])->name('admin.otp.resend');
    });

    // Protected Admin Routes
    Route::middleware(['auth:sanctum', 'super_admin'])->group(function () {
        Route::post('/logout', [AdminOtpController::class, 'logout'])->name('admin.logout');

        // Dashboard
        Route::get('/', Dashboard::class)->name('admin.dashboard');

        // Customers
        Route::get('/customers', Index::class)->name('admin.customers.index');
        Route::get('/customers/create', CreateWizard::class)->name('admin.customers.create');
        Route::get('/customers/{customer}', Show::class)->name('admin.customers.show');
        Route::get('/customers/{customer}/edit', Edit::class)->name('admin.customers.edit');
    });
});
