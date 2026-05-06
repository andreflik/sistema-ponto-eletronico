<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimeEntryController;
use App\Http\Controllers\Admin\TimeEntryAdminController;
use App\Http\Controllers\TimeEntryAdjustmentRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/ponto', [TimeEntryController::class, 'index'])->name('ponto.index');

    Route::post('/ponto/entrada', [TimeEntryController::class, 'clockIn'])->name('ponto.clockin');
    Route::post('/ponto/intervalo-inicio', [TimeEntryController::class, 'breakStart'])->name('ponto.breakstart');
    Route::post('/ponto/intervalo-fim', [TimeEntryController::class, 'breakEnd'])->name('ponto.breakend');
    Route::post('/ponto/saida', [TimeEntryController::class, 'clockOut'])->name('ponto.clockout');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/pontos', [TimeEntryAdminController::class, 'index'])->name('admin.pontos');
});

Route::get('/admin/pontos/pdf', [TimeEntryAdminController::class, 'exportPdf'])->middleware(['auth', 'admin'])->name('admin.pontos.pdf');

Route::get('/admin/pontos/excel', [TimeEntryAdminController::class, 'exportExcel'])
    ->middleware(['auth', 'admin'])
    ->name('admin.pontos.excel');

Route::middleware(['auth'])->group(function () {
    Route::get('/ponto/ajuste', [TimeEntryAdjustmentRequestController::class, 'create'])
        ->name('ponto.ajuste.create');

    Route::post('/ponto/ajuste', [TimeEntryAdjustmentRequestController::class, 'store'])
        ->name('ponto.ajuste.store');
});

require __DIR__ . '/auth.php';
