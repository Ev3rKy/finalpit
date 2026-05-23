<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('patient_no');
            $table->string('ward_required')->nullable();
            $table->string('bed_number')->nullable();
            $table->date('date_placed_waiting')->nullable();
            $table->integer('expected_stay')->nullable();
            $table->date('date_placed_ward')->nullable();
            $table->date('date_expected_leave')->nullable();
            $table->string('type')->default('IN-PATIENT');
            $table->date('date_actually_left')->nullable();
            $table->string('discharge_type')->nullable();
            $table->text('discharge_notes')->nullable();
            $table->string('followup_appointment')->nullable();
            $table->string('medications_on_discharge')->nullable();
            $table->string('appointment_number')->nullable();
            $table->string('clinic_date_time')->nullable();
            $table->string('consultant')->nullable();
            $table->string('examination_room')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};