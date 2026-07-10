<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('class_request_id')->nullable();
            $table->enum('type', ['hold', 'charge', 'refund']);
            $table->unsignedBigInteger('amount'); // Số tiền giao dịch (VND)
            $table->string('description')->nullable();
            $table->enum('status', ['pending', 'completed', 'failed'])->default('completed');
            $table->string('payment_order_ref')->nullable();
            $table->timestamps();
        });

        if (Schema::hasTable('payment_orders')) {
            Schema::table('payment_orders', function (Blueprint $table) {
                if (!Schema::hasColumn('payment_orders', 'class_request_id')) {
                    $table->unsignedBigInteger('class_request_id')->nullable()->after('user_id');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};