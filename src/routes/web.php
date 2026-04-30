<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimeEntryController;
use Illuminate\Support\Facades\Route;

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


    Route::get('/ponto', [TimeEntryController::class, 'index'])->name('ponto.index');

    Route::post('/ponto/entrada', [TimeEntryController::class, 'clockIn'])->name('ponto.clockin');
    Route::post('/ponto/intervalo-inicio', [TimeEntryController::class, 'breakStart'])->name('ponto.breakstart');
    Route::post('/ponto/intervalo-fim', [TimeEntryController::class, 'breakEnd'])->name('ponto.breakend');
    Route::post('/ponto/saida', [TimeEntryController::class, 'clockOut'])->name('ponto.clockout');
});

require __DIR__ . '/auth.php';
