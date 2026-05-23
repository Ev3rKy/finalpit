<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('drug_number');
            $table->string('drug_name');
            $table->string('description')->nullable();
            $table->string('dosage')->nullable();
            $table->string('method_of_admin')->nullable();
            $table->integer('units_per_day')->nullable();
            $table->date('start_date');
            $table->date('finish_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};