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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); //id

            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete(); // liên kết lớp học
            $table->foreignId('student_id')->constrained()->cascadeOnDelete(); //id học viên
            $table->foreignId('tutor_id')->constrained()->cascadeOnDelete(); //id gia sư

            $table->integer('rating'); // Đánh giá gia sư(1-5 sao)
            $table->text('comment')->nullable(); // Bình luận của học viên về gia sư

            $table->timestamps(); //created_at và updated_at
            $table->softDeletes(); //deleted_at

            $table->unique('class_id'); // Ràng buộc duy nhất mỗi lớp học chỉ có 1 review
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};