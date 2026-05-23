<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration {
    public function up(): void {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('staff_id_code')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('staff'); // staff, doctor, nurse
            $table->string('specialty')->nullable(); // for doctors/nurses
            $table->boolean('is_available')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('staff'); }
};
