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
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_ref')->unique();
            $table->decimal('amount_vnd', 15, 0);
            $table->integer('coin_amount');
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('vnpay_txn_no')->nullable();
            $table->json('gateway_response')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
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
