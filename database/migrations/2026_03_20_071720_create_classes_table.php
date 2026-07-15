<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('class_request_id')->constrained('class_requests')->cascadeOnDelete(); // ID yêu cầu lớp học
            $table->foreignId('tutor_id')->constrained('tutors')->cascadeOnDelete(); // ID gia sư nhận lớp
            $table->enum('status', ['payment_pending', 'active', 'completed', 'cancelled'])->default('payment_pending'); // Trạng thái lớp học
 
            $table->timestamps(); // created_at và updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};