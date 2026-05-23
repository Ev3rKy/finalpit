<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->string('patient_full_name');
            $table->integer('age')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('religion')->nullable();
            $table->text('complete_address')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('doctor');
            $table->dateTime('treatment_datetime');
            $table->string('procedure');
            $table->string('bp')->nullable();
            $table->string('temperature')->nullable();
            $table->string('spo2')->nullable();
            $table->text('medical_notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('medical_records'); }
};
