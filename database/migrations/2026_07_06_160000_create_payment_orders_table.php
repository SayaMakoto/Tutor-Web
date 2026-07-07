<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_orders', function (Blueprint $table) {
            $table->id(); // Mã giao dịch
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Mã người dùng
            $table->string('order_ref')->unique(); // Mã tham chiếu đơn hàng
            $table->unsignedBigInteger('amount_vnd'); // Số tiền VND
            $table->unsignedBigInteger('coin_amount'); // Số lượng coin
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending'); // Trạng thái
            // pending: đang chờ xử lý
            // success: thành công
            // failed: thất bại
            $table->string('payment_method'); // Phương thức thanh toán (ví dụ: vnpay, momo, paypal)
            $table->string('vnpay_txn_no')->nullable(); // Mã giao dịch VNPAY (nếu thanh toán bằng VNPAY)
            $table->json('gateway_response')->nullable(); // Phản hồi từ cổng thanh toán (nếu có)
            $table->timestamp('expires_at')->nullable(); // Thời gian hết hạn của đơn hàng
            $table->timestamps(); // Timestamps created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_orders');
    }
};