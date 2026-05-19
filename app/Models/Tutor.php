<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tutor extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'bio',
        'education',
        'experience',
        'status'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(
            Subject::class,
            'tutor_subjects', // tên bảng pivot
            'tutor_id',       // khóa ngoại của Tutor
            'subject_id'      // khóa ngoại của Subject
        );
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function documents()
    {
        return $this->hasMany(TutorDocument::class);
    }

    public function classRequests()
    {
        return $this->hasMany(ClassRequest::class, 'tutor_id');
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS CONFIG
    |--------------------------------------------------------------------------
    */

    public static function statusOptions()
    {
        return [
            'draft' => 'Mới tạo',
            'pending' => 'Chờ duyệt',
            'approved' => 'Đã duyệt',
            'rejected' => 'Từ chối',
        ];
    }

    public static function statusColors()
    {
        return [
            'draft' => 'bg-gray-100 text-gray-700',
            'pending' => 'bg-yellow-100 text-yellow-700',
            'approved' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getStatusLabelAttribute()
    {
        return self::statusOptions()[$this->status] ?? 'Không xác định';
    }

    public function getStatusColorAttribute()
    {
        return self::statusColors()[$this->status] ?? 'bg-gray-100 text-gray-700';
    }
}