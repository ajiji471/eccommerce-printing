<?php

use App\Http\Controllers\Account\DashboardController as AccountDashboardController;
use App\Http\Controllers\Account\SessionController as AccountSessionController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Platform\DashboardController as PlatformDashboardController;
use App\Http\Controllers\Storefront\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('akun', AccountDashboardController::class)
    ->middleware('auth')
    ->name('account.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('akun/perangkat', [AccountSessionController::class, 'index'])
        ->name('account.sessions.index');

    Route::post('akun/perangkat/logout-lain', [AccountSessionController::class, 'destroyOthers'])
        ->name('account.sessions.destroy-others');
});

Route::get('admin', AdminDashboardController::class)
    ->middleware(['auth', 'tenant.role:admin'])
    ->name('admin.dashboard');

Route::get('platform', PlatformDashboardController::class)
    ->middleware(['auth', 'super.admin'])
    ->name('platform.dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
