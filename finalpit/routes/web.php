<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\WardAllocationController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('staff', StaffController::class);
Route::resource('ward-allocation', WardAllocationController::class);

Route::post('staff/{staff_number}/qualifications', [StaffController::class, 'addQualification'])
     ->name('staff.qualifications.store');

Route::post('staff/{staff_number}/experience', [StaffController::class, 'addExperience'])
     ->name('staff.experience.store');
