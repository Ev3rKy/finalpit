<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ward', function (Blueprint $table) {
            $table->integer('ward_number')->primary();
            $table->string('ward_name');
            $table->string('location')->nullable();
            $table->integer('total_beds')->nullable();
            $table->string('tel_extn')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ward');
    }
};