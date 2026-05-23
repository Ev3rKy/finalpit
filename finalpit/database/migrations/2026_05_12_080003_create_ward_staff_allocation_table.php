<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ward_staff_allocation', function (Blueprint $table) {
            $table->id('allocation_id');
            $table->string('staff_number');
            $table->foreign('staff_number')
                  ->references('staff_number')
                  ->on('staff')
                  ->onDelete('cascade');
            $table->unsignedBigInteger('ward_number');
            $table->date('week_start_date');
            $table->string('shift');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ward_staff_allocation');
    }
};