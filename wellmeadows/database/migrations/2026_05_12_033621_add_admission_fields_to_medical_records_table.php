<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->date('date_placed')->nullable();
            $table->integer('expected_stay')->nullable();
            $table->date('date_expected_leave')->nullable();
            $table->date('date_actually_left')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn(['date_placed', 'expected_stay', 'date_expected_leave', 'date_actually_left']);
        });
    }
};