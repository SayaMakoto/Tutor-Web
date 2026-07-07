<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    protected $fillable = [
        'wallet_id', 'class_request_id', 'type',
        'amount', 'description', 'status', 'payment_order_ref',
    ];

    const TYPES = [
        'topup'   => ['label' => 'Nạp Xu',     'color' => 'text-emerald-600', 'sign' => '+'],
        'hold'    => ['label' => 'Tạm giữ',     'color' => 'text-amber-600',   'sign' => '-'],
        'charge'  => ['label' => 'Khấu trừ',    'color' => 'text-red-500',     'sign' => '-'],
        'refund'  => ['label' => 'Hoàn tiền',   'color' => 'text-blue-600',    'sign' => '+'],
        'release' => ['label' => 'Hoàn xu',     'color' => 'text-red-500',     'sign' => '-'],
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function classRequest(): BelongsTo
    {
        return $this->belongsTo(ClassRequest::class, 'class_request_id');
    }

    public function paymentOrder(): BelongsTo
    {
        return $this->belongsTo(PaymentOrder::class, 'payment_order_ref', 'order_ref');
    }
}
