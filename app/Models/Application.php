<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'tutor_id',
        'class_request_id',
        'message',
        'status',
    ];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function classRequest()
    {
        return $this->belongsTo(ClassRequest::class);
    }

    protected static function booted()
    {
        static::updated(function ($application) {

            if ($application->isDirty('status') && $application->status === 'accepted') {

                $application->classRequest()->update([
                    'status' => 'assigned'
                ]);
            }
        });
    }

    public const STATUSES = [
        'pending' => [
            'label' => 'Chờ duyệt',
            'color' => 'bg-yellow-100 text-yellow-700',
        ],
        'accepted' => [
            'label' => 'Đã chấp nhận',
            'color' => 'bg-green-100 text-green-700',
        ],
        'rejected' => [
            'label' => 'Từ chối',
            'color' => 'bg-red-100 text-red-700',
        ],
    ];

    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status]['label'] ?? 'Không rõ';
    }

    public function getStatusColorAttribute()
    {
        return self::STATUSES[$this->status]['color'] ?? 'bg-gray-100 text-gray-700';
    }
}