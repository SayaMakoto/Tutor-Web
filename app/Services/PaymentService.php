<?php

namespace App\Services;

use App\Models\User;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * Tạo một giao dịch đóng băng (hold) 25% phí nhận lớp khi gia sư thanh toán thành công
     */
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

    /**
     * Hủy lớp học trong thời gian bảo hành và hoàn trả 20% phí cho gia sư, 5% thu phí dịch vụ
     */
    public function cancelClassAndRefund(User $user, float $totalValueVnd, int $classRequestId): void
    {
        $holdAmount = (int) round($totalValueVnd * 0.25);
        $refundAmount = (int) round($totalValueVnd * 0.20);
        $chargeAmount = $holdAmount - $refundAmount;

        DB::transaction(function () use ($user, $refundAmount, $chargeAmount, $classRequestId) {
            // Ghi nhận hoàn tiền 20% cho gia sư (type refund)
            PaymentTransaction::create([
                'user_id'          => $user->id,
                'class_request_id' => $classRequestId,
                'type'             => 'refund',
                'amount'           => $refundAmount,
                'description'      => "Hoàn trả 20% phí nhận lớp #{$classRequestId} do hủy học thử",
                'status'           => 'completed',
            ]);

            // Ghi nhận khấu trừ 5% phí dịch vụ (type charge)
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

    /**
     * Hoàn thành lớp học - chuyển 25% phí đang đóng băng thành doanh thu hệ thống
     */
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
