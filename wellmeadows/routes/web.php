<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedicalRecordController;

// Redirect root to patients
Route::get('/', function () {
    return redirect()->route('patients.index');
});

// Patient Management Routes
Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
Route::get('/patients/{id}/edit', [PatientController::class, 'edit'])->name('patients.edit');
Route::patch('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');

// Medical Records Routes
Route::get('/patients/{id}/medical', [MedicalRecordController::class, 'index'])->name('patients.medical');
Route::post('/medications', [MedicalRecordController::class, 'store'])->name('medications.store');
Route::get('/medical-records', [MedicalRecordController::class, 'patientList'])->name('medical.index');
Route::get('/ward-assignment', [MedicalRecordController::class, 'wardIndex'])->name('ward.index');
Route::post('/ward-assignment', [MedicalRecordController::class, 'wardStore'])->name('ward.store');

use App\Http\Controllers\AdmissionController;

Route::get('/admission-discharge', [AdmissionController::class, 'index'])->name('admission.index');
Route::post('/admission-discharge', [AdmissionController::class, 'store'])->name('admission.store');
Route::patch('/admission-discharge/{id}/discharge', [AdmissionController::class, 'discharge'])->name('admission.discharge');