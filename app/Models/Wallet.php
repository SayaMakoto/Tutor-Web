<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    protected $fillable = ['user_id', 'balance', 'frozen_balance', 'total_topped_up'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class)->latest();
    }

    /** Tổng xu hiển thị (khả dụng + đang giữ) */
    public function getTotalAttribute(): int
    {
        return $this->balance + $this->frozen_balance;
    }

    /** Quy đổi xu → VNĐ */
    public function toVnd(int $xu): int
    {
        return $xu * (int) config('payment.coin_to_vnd', 1000);
    }
}
