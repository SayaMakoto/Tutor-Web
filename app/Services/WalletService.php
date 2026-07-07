<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class WalletService
{
    /**
     * Cộng xu vào ví sau khi nạp tiền thành công
     */
    public function topUp(User $user, int $coinAmount, string $orderRef): void
    {
        DB::transaction(function () use ($user, $coinAmount, $orderRef) {
            $wallet = $user->getOrCreateWallet();

            $wallet->increment('balance', $coinAmount);
            $wallet->increment('total_topped_up', $coinAmount);

            $wallet->transactions()->create([
                'type'              => 'topup',
                'amount'            => $coinAmount,
                'description'       => "Nạp {$coinAmount} Xu — Đơn {$orderRef}",
                'status'            => 'completed',
                'payment_order_ref' => $orderRef,
            ]);
        });
    }

    /**
     * Tạm khóa xu khi học viên chọn gia sư (Escrow)
     */
    public function holdBalance(User $user, int $coinAmount, int $classRequestId): bool
    {
        $wallet = $user->getOrCreateWallet();

        if ($wallet->balance < $coinAmount) {
            return false; // Không đủ xu
        }

        DB::transaction(function () use ($wallet, $coinAmount, $classRequestId) {
            $wallet->decrement('balance', $coinAmount);
            $wallet->increment('frozen_balance', $coinAmount);

            $wallet->transactions()->create([
                'type'             => 'hold',
                'amount'           => $coinAmount,
                'class_request_id' => $classRequestId,
                'description'      => "Tạm giữ {$coinAmount} Xu cho lớp #{$classRequestId}",
                'status'           => 'completed',
            ]);
        });

        return true;
    }

    /**
     * Khấu trừ thực tế sau bảo hành thành công
     */
    public function chargeBalance(User $user, int $coinAmount, int $classRequestId): void
    {
        $wallet = $user->getOrCreateWallet();

        DB::transaction(function () use ($wallet, $coinAmount, $classRequestId) {
            $wallet->decrement('frozen_balance', $coinAmount);

            $wallet->transactions()->create([
                'type'             => 'charge',
                'amount'           => $coinAmount,
                'class_request_id' => $classRequestId,
                'description'      => "Khấu trừ phí nhận lớp #{$classRequestId}",
                'status'           => 'completed',
            ]);
        });
    }

    /**
     * Hoàn xu khi lớp vỡ trong thời gian bảo hành
     */
    public function refundBalance(User $user, int $coinAmount, int $classRequestId): void
    {
        $wallet = $user->getOrCreateWallet();

        DB::transaction(function () use ($wallet, $coinAmount, $classRequestId) {
            $wallet->decrement('frozen_balance', $coinAmount);
            $wallet->increment('balance', $coinAmount);

            $wallet->transactions()->create([
                'type'             => 'refund',
                'amount'           => $coinAmount,
                'class_request_id' => $classRequestId,
                'description'      => "Hoàn {$coinAmount} Xu — Vỡ lớp #{$classRequestId}",
                'status'           => 'completed',
            ]);
        });
    }

    /**
     * Hoàn xu từ ví khả dụng (rút tiền)
     */
    public function releaseBalance(User $user, int $coinAmount): bool
    {
        $wallet = $user->getOrCreateWallet();

        if ($wallet->balance < $coinAmount) {
            return false;
        }

        DB::transaction(function () use ($wallet, $coinAmount) {
            $wallet->decrement('balance', $coinAmount);

            $wallet->transactions()->create([
                'type'        => 'release',
                'amount'      => $coinAmount,
                'description' => "Hoàn xu khả dụng: Rút {$coinAmount} Xu",
                'status'      => 'completed',
            ]);
        });

        return true;
    }

    /**
     * Hủy lớp học trong thời gian bảo hành và hoàn trả 20% xu, giữ lại 5% phí
     */
    public function cancelClassAndRefund(User $user, int $totalValueInCoins, int $classRequestId): void
    {
        $wallet = $user->getOrCreateWallet();

        $frozenAmount = (int) round($totalValueInCoins * 0.25);
        $refundAmount = (int) round($totalValueInCoins * 0.20);
        $chargeAmount = $frozenAmount - $refundAmount;

        DB::transaction(function () use ($wallet, $frozenAmount, $refundAmount, $chargeAmount, $classRequestId) {
            // Giải phóng ví đóng băng (đảm bảo không bị âm)
            $decrementAmount = min($wallet->frozen_balance, $frozenAmount);
            if ($decrementAmount > 0) {
                $wallet->decrement('frozen_balance', $decrementAmount);
            }
            
            // Hoàn trả 20% vào ví khả dụng
            $wallet->increment('balance', $refundAmount);

            // Ghi nhận hóa đơn hoàn tiền 20%
            $wallet->transactions()->create([
                'type'             => 'refund',
                'amount'           => $refundAmount,
                'class_request_id' => $classRequestId,
                'description'      => "Hoàn trả 20% phí nhận lớp #{$classRequestId} do hủy học thử",
                'status'           => 'completed',
            ]);

            // Ghi nhận hóa đơn khấu trừ 5% phí dịch vụ
            if ($chargeAmount > 0) {
                $wallet->transactions()->create([
                    'type'             => 'charge',
                    'amount'           => $chargeAmount,
                    'class_request_id' => $classRequestId,
                    'description'      => "Khấu trừ 5% phí dịch vụ xử lý lớp #{$classRequestId}",
                    'status'           => 'completed',
                ]);
            }
        });
    }
}

