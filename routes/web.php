<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FilterController;

Route::get('/', function () {
    return view('welcome');
});

// Report Routes
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/data', [ReportController::class, 'getReportData'])->name('reports.data');

// Filter Routes
Route::prefix('filters')->name('filters.')->group(function () {
    Route::get('/search-users', [FilterController::class, 'searchUsers'])->name('users');
    Route::get('/search-games', [FilterController::class, 'searchGames'])->name('games');
    Route::get('/search-providers', [FilterController::class, 'searchProviders'])->name('providers');
});
