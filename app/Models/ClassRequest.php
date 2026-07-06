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

    public function getTutorIdAttribute()
    {
        return $this->tutorClass?->tutor_id;
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

    /** Tính tổng giá trị lớp học dự kiến */
    public function getTotalValueAttribute(): float
    {
        $sessionsPerWeek = $this->schedules->count() ?: 1;

        $hoursPerSession = 2.0;
        $firstSchedule = $this->schedules->first();
        if ($firstSchedule) {
            $start = \Carbon\Carbon::parse($firstSchedule->start_time);
            $end = \Carbon\Carbon::parse($firstSchedule->end_time);
            $diff = $start->diffInMinutes($end);
            if ($diff > 0) {
                $hoursPerSession = $diff / 60.0;
            }
        }

        $totalWeeks = 4;
        $weeksStr = $this->weeks;
        if (preg_match('/(\d+)\s*(tuần|tháng)/i', $weeksStr, $matches)) {
            $val = intval($matches[1]);
            $unit = mb_strtolower(trim($matches[2]));
            if ($unit === 'tháng') {
                $totalWeeks = $val * 4;
            } else {
                $totalWeeks = $val;
            }
        } elseif (is_numeric($weeksStr)) {
            $totalWeeks = intval($weeksStr);
        }

        return $this->fee * $hoursPerSession * $sessionsPerWeek * $totalWeeks;
    }

    /** Lấy địa chỉ bị che phần chi tiết */
    public function getMaskedLocationAttribute(): string
    {
        if (!$this->location) {
            return 'Chưa xác định';
        }

        $parts = array_map('trim', explode(',', $this->location));
        if (count($parts) >= 2) {
            $district = $parts[count($parts) - 2];
            $city = $parts[count($parts) - 1];
            return "**, **, {$district}, {$city}";
        }

        return "*** (Thanh toán để xem)";
    }

    /** Kiểm tra xem user hiện tại có thể xem thông tin liên hệ và địa chỉ chi tiết hay không */
    public function canViewContactDetails($user): bool
    {
        if (!$user) {
            return false;
        }

        // Admin luôn có quyền xem
        if ($user->role === 'admin') {
            return true;
        }

        // Học viên sở hữu lớp học luôn có quyền xem
        if ($user->student && $this->student_id === $user->student->id) {
            return true;
        }

        // Gia sư được phân công và lớp học ở trạng thái active (đã đóng phí) thì được xem
        if ($user->tutor && $this->tutorClass) {
            if ($this->tutorClass->tutor_id === $user->tutor->id && $this->tutorClass->status === 'active') {
                return true;
            }
        }

        return false;
    }
}