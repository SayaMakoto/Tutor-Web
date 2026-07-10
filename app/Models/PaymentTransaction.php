<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'user_id', 'class_request_id', 'type',
        'amount', 'description', 'status', 'payment_order_ref',
    ];

    const TYPES = [
        'hold'    => ['label' => 'Tạm giữ (Escrow)', 'color' => 'text-amber-600',   'sign' => '-'],
        'charge'  => ['label' => 'Khấu trừ (Phí)',   'color' => 'text-red-500',     'sign' => '-'],
        'refund'  => ['label' => 'Hoàn tiền',        'color' => 'text-blue-600',    'sign' => '+'],
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
