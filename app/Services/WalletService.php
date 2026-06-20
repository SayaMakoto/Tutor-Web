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
}
