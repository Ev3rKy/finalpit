<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_qualifications', function (Blueprint $table) {
            $table->id('qualification_id');
            $table->string('staff_number');
            $table->foreign('staff_number')
                  ->references('staff_number')
                  ->on('staff')
                  ->onDelete('cascade');
            $table->string('qualification_type');
            $table->date('date_obtained')->nullable();
            $table->string('institution')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_qualifications');
    }
};
