<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\TreatmentHistoryController;
use App\Http\Controllers\StaffAssignmentController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/signin', [AuthController::class, 'showSignin'])->name('signin');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth.staff')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment');
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/medical-record', [MedicalRecordController::class, 'index'])->name('medical-record');
    Route::post('/medical-record', [MedicalRecordController::class, 'store'])->name('medical-record.store');
    Route::get('/treatment-history', [TreatmentHistoryController::class, 'index'])->name('treatment-history');
    Route::get('/assign-staff', [StaffAssignmentController::class, 'index'])->name('assign-staff');
    Route::post('/assign-staff', [StaffAssignmentController::class, 'store'])->name('assign-staff.store');
    Route::patch('/assign-staff/{id}/toggle', [StaffAssignmentController::class, 'toggleTask'])->name('assign-staff.toggle');
});
