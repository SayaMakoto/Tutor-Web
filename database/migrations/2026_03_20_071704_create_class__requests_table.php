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
        Schema::create('class_requests', function (Blueprint $table) {
            $table->id(); // ID của yêu cầu lớp học

            $table->foreignId('student_id')->constrained()->cascadeOnDelete(); // Người tạo lớp
            $table->foreignId('tutor_id')->nullable()->constrained('tutors')->nullOnDelete(); // Gia sư nhận lớp
            $table->foreignId('subject_id')->nullable()->constrained(); // Môn học
            $table->foreignId('grade_id')->nullable()->constrained(); // Ngành học

            $table->string('subject_request')->nullable(); // Dành cho trường hợp môn học không có trong danh sách
            $table->string('grade_request')->nullable(); // Dành cho trường hợp ngành học không có trong danh sách

            $table->string('degree'); //Trình độ của gia sư
            $table->string('experience'); // Kinh nghiệm gia sư
            $table->enum('gender', ['male', 'female', 'no_need']); // Giới tính của gia sư
            $table->string('age_range'); // Độ tuổi của gia sư
            $table->decimal('fee', 10, 2); // Mức học phí dự kiến của lớp học
            $table->text('description')->nullable(); // Mô tả thêm về yêu cầu gia sư

            $table->enum('study_type', ['online', 'offline']); // Hình thức học
            $table->string('location')->nullable(); // Địa điểm học (nếu có)

            $table->string('weeks'); // Số tuần học
            $table->string('schedule'); // Ngày học (VD: Thứ 2,4,6)
            $table->string('time'); // Thời gian học (VD: 18:00-20:00)

            $table->enum('status', ['pending', 'approved', 'rejected', 'assigned', 'payment_pending', 'completed', 'cancelled'])->default('pending'); //Trạng thái
            // pending: Đang chờ duyệt
            // approved: Yêu cầu đã được duyệt và đang mở để gia sư ứng tuyển
            // rejected: Yêu cầu đã bị từ chối
            // assigned: Đã có gia sư nhận lớp
            // payment_pending: Đang chờ thanh toán từ học sinh
            // completed: Lớp học đã hoàn thành
            // cancelled: Lớp học đã bị hủy

            $table->timestamps(); // created_at và updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_requests');
    }
};