<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WardController;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Bills — full CRUD
Route::get('/bills',                  [BillController::class, 'index'])->name('bills.index');
Route::get('/bills/create',           [BillController::class, 'create'])->name('bills.create');
Route::post('/bills',                 [BillController::class, 'store'])->name('bills.store');
Route::get('/bills/outstanding',      [BillController::class, 'outstanding'])->name('bills.outstanding');
Route::get('/bills/{bill}',           [BillController::class, 'show'])->name('bills.show');
Route::get('/bills/{bill}/edit',      [BillController::class, 'edit'])->name('bills.edit');
Route::put('/bills/{bill}',           [BillController::class, 'update'])->name('bills.update');
Route::delete('/bills/{bill}',        [BillController::class, 'destroy'])->name('bills.destroy');
Route::patch('/bills/{bill}/pay',     [BillController::class, 'markPaid'])->name('bills.pay');

// Wards — full CRUD
Route::get('/wards',             [WardController::class, 'index'])->name('wards.index');
Route::get('/wards/create',      [WardController::class, 'create'])->name('wards.create');
Route::post('/wards',            [WardController::class, 'store'])->name('wards.store');
Route::get('/wards/{ward}/edit', [WardController::class, 'edit'])->name('wards.edit');
Route::put('/wards/{ward}',      [WardController::class, 'update'])->name('wards.update');
Route::delete('/wards/{ward}',   [WardController::class, 'destroy'])->name('wards.destroy');

// Reports
Route::get('/reports/revenue',   [ReportController::class, 'revenue'])->name('reports.revenue');
Route::get('/reports/occupancy', [ReportController::class, 'occupancy'])->name('reports.occupancy');
Route::get('/reports/summaries', [ReportController::class, 'summaries'])->name('reports.summaries');
