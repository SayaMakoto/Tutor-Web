<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',

        'grade_id',
        'subject_id',

        'degree',
        'experience',
        'gender',
        'age_range',
        'fee',
        'description',

        'study_type',
        'location',

        'weeks',

        'status'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function tutorClass()
    {
        return $this->hasOne(TutorClass::class, 'class_request_id');
    }

    public function tutor()
    {
        return $this->hasOneThrough(
            Tutor::class,
            TutorClass::class,
            'class_request_id', // Khóa ngoại trên TutorClass
            'id',               // Khóa ngoại trên Tutor (khóa chính)
            'id',               // Khóa nội trên ClassRequest (khóa chính)
            'tutor_id'          // Khóa nội trên TutorClass
        );
    }

    public function schedules()
    {
        return $this->hasMany(ClassSchedule::class, 'class_request_id');
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