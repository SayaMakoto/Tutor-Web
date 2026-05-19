<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'tutor_id',

        'grade_id',
        'grade_request',

        'subject_id',
        'subject_request',

        'degree',
        'experience',
        'gender',
        'age_range',
        'fee',
        'description',

        'study_type',
        'location',

        'weeks',
        'schedule',
        'time',

        'status'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function getStudentNameAttribute()
    {
        return $this->student?->user?->name;
    }

    public const STATUSES = [
        'pending' => [
            'label' => 'Đang chờ duyệt',
            'color' => 'bg-yellow-100 text-yellow-800',
        ],
        'approved' => [
            'label' => 'Đã duyệt',
            'color' => 'bg-green-100 text-green-800',
        ],
        'rejected' => [
            'label' => 'Đã từ chối',
            'color' => 'bg-red-100 text-red-800',
        ],
        'assigned' => [
            'label' => 'Đã có gia sư',
            'color' => 'bg-blue-100 text-blue-800',
        ],
        'payment_pending' => [
            'label' => 'Chờ thanh toán',
            'color' => 'bg-orange-100 text-orange-800',
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

    public static function statusOptions()
    {
        return collect(self::statuses())
            ->mapWithKeys(fn($item, $key) => [$key => $item['label']])
            ->toArray();
    }

    public function getGenderLabelAttribute()
    {
        return match ($this->gender) {
            'male' => 'Nam',
            'female' => 'Nữ',
            'no_need' => 'Không yêu cầu',
            default => 'Không xác định',
        };
    }
}