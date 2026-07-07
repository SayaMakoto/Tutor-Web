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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id(); // Mã ví
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade'); // Mã người dùng
            $table->unsignedBigInteger('balance')->default(0); // Số dư khả dụng
            $table->unsignedBigInteger('frozen_balance')->default(0); // Số dư bị đóng băng
            $table->unsignedBigInteger('total_topped_up')->default(0); // Tổng số tiền nạp vào
            $table->timestamps(); // created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};