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
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('class_request_id')->constrained('class_requests')->cascadeOnDelete(); // ID yêu cầu lớp học
            $table->string('day_of_week'); // Ngày trong tuần (Thứ 2, Thứ 3,...)
            $table->time('start_time'); // Thời gian bắt đầu
            $table->time('end_time'); // Thời gian kết thúc

            $table->timestamps(); // created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
