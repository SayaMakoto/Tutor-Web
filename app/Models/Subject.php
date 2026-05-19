<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'status',
    ];

    public function tutors()
    {
        return $this->belongsToMany(
            Tutor::class,
            'tutor_subjects',
            'subject_id',
            'tutor_id'
        );
    }

    public function grades()
    {
        return $this->belongsToMany(Grade::class);
    }

    public function classRequests()
    {
        return $this->hasMany(ClassRequest::class, 'subject_id');
    }
}