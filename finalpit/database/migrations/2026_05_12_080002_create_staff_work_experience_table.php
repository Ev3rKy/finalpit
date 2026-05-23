<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_work_experience', function (Blueprint $table) {
            $table->id('experience_id');
            $table->string('staff_number');
            $table->foreign('staff_number')
                  ->references('staff_number')
                  ->on('staff')
                  ->onDelete('cascade');
            $table->string('position')->nullable();
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable();
            $table->string('organisation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_work_experience');
    }
};