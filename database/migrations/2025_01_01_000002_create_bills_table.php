<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('bill_no')->unique();       // e.g. #BL-2025
            $table->string('patient_name');
            $table->string('patient_id');
            $table->foreignId('ward_id')->constrained()->onDelete('restrict');
            $table->string('service');                 // Room+Treatment, Surgery+Room, etc.
            $table->unsignedBigInteger('amount');      // in PHP Peso (integer, no decimals)
            $table->date('due_date')->nullable();
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
