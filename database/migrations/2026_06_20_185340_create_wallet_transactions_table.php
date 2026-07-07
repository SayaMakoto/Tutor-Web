<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id(); // Mã giao dịch
            $table->foreignId('wallet_id')
                ->constrained('wallets')
                ->onDelete('cascade'); // Mã ví
            $table->unsignedBigInteger('class_request_id')->nullable(); // Mã yêu cầu lớp học (nếu có)
            $table->enum('type', ['topup', 'hold', 'charge', 'refund', 'release']); // Loại giao dịch
            // topup: nạp tiền vào ví
            // hold: giữ tiền trong ví (dành cho các giao dịch chưa hoàn tất)
            // charge: trừ tiền từ ví (dành cho các giao dịch đã hoàn tất)
            // refund: hoàn tiền vào ví (dành cho các giao dịch đã hoàn tất)
            // release: giải phóng tiền giữ trong ví (dành cho các giao dịch chưa hoàn tất)
            $table->unsignedBigInteger('amount'); // Số tiền giao dịch
            $table->string('description')->nullable(); // Mô tả giao dịch
            $table->enum('status', ['pending', 'completed', 'failed'])->default('completed'); // Trạng thái giao dịch
            // pending: đang chờ xử lý
            // completed: đã hoàn tất
            // failed: thất bại
            $table->string('payment_order_ref')->nullable(); // Mã tham chiếu đơn hàng thanh toán (nếu có)
            $table->timestamps(); // created_at và updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};