<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TutorSubject extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'tutor_id',
        'subject_id'
    ];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}