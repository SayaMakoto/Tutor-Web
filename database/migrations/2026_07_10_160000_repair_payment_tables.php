<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Recreate the payment schema when older migrations are marked as run but
     * their tables were renamed or removed manually.
     */
    public function up(): void
    {
        if (! Schema::hasTable('payment_orders')) {
            Schema::create('payment_orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('class_request_id')->nullable()->constrained('class_requests')->nullOnDelete();
                $table->string('order_ref')->unique();
                $table->unsignedBigInteger('amount_vnd');
                $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
                $table->string('payment_method');
                $table->string('vnpay_txn_no')->nullable();
                $table->json('gateway_response')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('payment_orders', function (Blueprint $table) {
                if (! Schema::hasColumn('payment_orders', 'class_request_id')) {
                    $table->unsignedBigInteger('class_request_id')->nullable()->after('user_id');
                }

                if (Schema::hasColumn('payment_orders', 'coin_amount')) {
                    $table->dropColumn('coin_amount');
                }
            });
        }

        if (! Schema::hasTable('payment_transactions')) {
            Schema::create('payment_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('class_request_id')->nullable()->constrained('class_requests')->nullOnDelete();
                $table->enum('type', ['hold', 'charge', 'refund']);
                $table->unsignedBigInteger('amount');
                $table->string('description')->nullable();
                $table->enum('status', ['pending', 'completed', 'failed'])->default('completed');
                $table->string('payment_order_ref')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // This is a repair migration: never remove payment records on rollback.
    }
};
