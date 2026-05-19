<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'tutor_id',
        'class_request_id',
        'amount',
        'status',
        'payment_method',
    ];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function classRequest()
    {
        return $this->belongsTo(ClassRequest::class);
    }
}