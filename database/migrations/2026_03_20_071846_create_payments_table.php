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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); //id

            $table->foreignId('tutor_id')->nullable()->constrained()->cascadeOnDelete(); //id gia sư (nullable)
            $table->foreignId('class_id')->nullable()->constrained('classes')->cascadeOnDelete(); //id lớp học (nullable)

            $table->decimal('amount', 10, 2); // Số tiền thanh toán

            $table->enum('payment_type', ['receive_class', 'subscription', 'refund']); // Loại thanh toán
            // receive_class: thanh toán nhận lớp
            // subscription: thanh toán đăng ký gói
            // refund: hoàn tiền

            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending'); //Trạng thái
            // pending: đang chờ xử lý
            // completed: đã hoàn thành
            // failed: thất bại
            // refunded: đã hoàn tiền

            $table->string('payment_method')->nullable(); //Phương thức thanh toán

            $table->timestamps(); //created_at và updated_at
            $table->softDeletes(); //deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};