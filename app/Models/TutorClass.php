<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TutorClass extends Model
{
    use SoftDeletes;

    protected $table = 'classes';

    protected $fillable = [
        'class_request_id',
        'tutor_id',
        'status',
    ];

    public function classRequest()
    {
        return $this->belongsTo(ClassRequest::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'class_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'class_id');
    }

    public const STATUSES = [
        'payment_pending' => [
            'label' => 'Chờ thanh toán',
            'color' => 'bg-orange-100 text-orange-800',
        ],
        'active' => [
            'label' => 'Đang học',
            'color' => 'bg-green-100 text-green-800',
        ],
        'completed' => [
            'label' => 'Hoàn thành',
            'color' => 'bg-emerald-100 text-emerald-800',
        ],
        'cancelled' => [
            'label' => 'Đã hủy',
            'color' => 'bg-gray-200 text-gray-700',
        ],
    ];

    public static function statuses()
    {
        return self::STATUSES;
    }

    public function getStatusLabelAttribute()
    {
        return self::statuses()[$this->status]['label'] ?? 'Không xác định';
    }

    public function getStatusColorAttribute()
    {
        return self::statuses()[$this->status]['color'] ?? 'bg-gray-100 text-gray-800';
    }
}
