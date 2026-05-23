<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('staff_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('patient_full_name');
            $table->string('treatment_type');
            $table->string('assigned_staff'); // name of doctor/nurse
            $table->string('staff_type')->default('doctor'); // doctor or nurse
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('staff_tasks'); }
};
