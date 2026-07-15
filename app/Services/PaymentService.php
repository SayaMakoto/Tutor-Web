<?php

namespace App\Services;

use App\Models\User;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function holdEscrow(User $user, int $amountVnd, int $classRequestId, string $orderRef): PaymentTransaction
    {
        return DB::transaction(function () use ($user, $amountVnd, $classRequestId, $orderRef) {
            return PaymentTransaction::create([
                'user_id'          => $user->id,
                'class_request_id' => $classRequestId,
                'type'             => 'hold',
                'amount'           => $amountVnd,
                'description'      => "Tạm khóa 25% phí nhận lớp học #{$classRequestId} (Học thử)",
                'status'           => 'completed',
                'payment_order_ref' => $orderRef,
            ]);
        });
    }

    public function cancelClassAndRefund(User $user, float $totalValueVnd, int $classRequestId): void
    {
        $holdAmount = (int) round($totalValueVnd * 0.25);
        $refundAmount = (int) round($totalValueVnd * 0.20);
        $chargeAmount = $holdAmount - $refundAmount;

        DB::transaction(function () use ($user, $refundAmount, $chargeAmount, $classRequestId) {
            PaymentTransaction::create([
                'user_id'          => $user->id,
                'class_request_id' => $classRequestId,
                'type'             => 'refund',
                'amount'           => $refundAmount,
                'description'      => "Hoàn trả 20% phí nhận lớp #{$classRequestId} do hủy học thử",
                'status'           => 'completed',
            ]);

            if ($chargeAmount > 0) {
                PaymentTransaction::create([
                    'user_id'          => $user->id,
                    'class_request_id' => $classRequestId,
                    'type'             => 'charge',
                    'amount'           => $chargeAmount,
                    'description'      => "Khấu trừ 5% phí dịch vụ xử lý lớp #{$classRequestId}",
                    'status'           => 'completed',
                ]);
            }
        });
    }

    public function chargeEscrow(User $user, int $amountVnd, int $classRequestId): PaymentTransaction
    {
        return DB::transaction(function () use ($user, $amountVnd, $classRequestId) {
            return PaymentTransaction::create([
                'user_id'          => $user->id,
                'class_request_id' => $classRequestId,
                'type'             => 'charge',
                'amount'           => $amountVnd,
                'description'      => "Chuyển 25% phí nhận lớp học #{$classRequestId} thành doanh thu hệ thống",
                'status'           => 'completed',
            ]);
        });
    }
}