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
        Schema::create('tutors', function (Blueprint $table) {
            $table->id(); //id gia sư

            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); //id người dùng
            $table->text('bio')->nullable(); //Giới thiệu bản thân
            $table->string('education'); //Học vấn
            $table->integer('experience'); // Số năm kinh nghiệm
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft'); //Trạng thái
            //draft: mới đăng ký, chưa hoàn thiện hồ sơ
            //pending: đang chờ duyệt hồ sơ
            //approved: hồ sơ đã được duyệt, có thể nhận lớp
            //rejected: hồ sơ bị từ chối, cần chỉnh sửa và nộp lại

            $table->timestamps(); //created_at và updated_at
            $table->softDeletes(); //deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutors');
    }
};