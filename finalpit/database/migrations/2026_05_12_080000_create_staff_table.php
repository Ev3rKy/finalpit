<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->string('staff_number')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->text('address');
            $table->string('tel_no')->nullable();
            $table->date('dob');
            $table->char('sex', 1);
            $table->string('nin')->unique();
            $table->string('position');
            $table->decimal('current_salary', 10, 2);
            $table->string('salary_scale')->nullable();
            $table->decimal('hours_per_week', 5, 2)->nullable();
            $table->string('contract_type');
            $table->string('payment_type')->nullable();
            $table->unsignedBigInteger('allocated_ward')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};