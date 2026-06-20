<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentOrder extends Model
{
    protected $fillable = [
        'user_id', 'order_ref', 'amount_vnd', 'coin_amount',
        'status', 'payment_method', 'vnpay_txn_no',
        'gateway_response', 'expires_at',
    ];

    protected $casts = [
        'gateway_response' => 'array',
        'expires_at'       => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool  { return $this->status === 'pending'; }
    public function isSuccess(): bool  { return $this->status === 'success'; }
    public function isExpired(): bool  { return $this->expires_at && now()->isAfter($this->expires_at); }
}
