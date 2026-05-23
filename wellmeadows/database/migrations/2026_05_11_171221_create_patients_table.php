<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_no')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->text('address');
            $table->string('tel_no')->nullable();
            $table->string('sex');
            $table->date('date_of_birth');
            $table->string('marital_status')->nullable();
            $table->date('date_registered');
            $table->string('status')->default('OUT-PATIENT');
            // Next of Kin
            $table->string('kin_full_name')->nullable();
            $table->string('kin_relationship')->nullable();
            $table->text('kin_address')->nullable();
            $table->string('kin_tel_no')->nullable();
            // Local Doctor
            $table->string('doctor_full_name')->nullable();
            $table->string('doctor_clinic_tel')->nullable();
            $table->text('doctor_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};