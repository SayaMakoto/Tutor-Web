<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $fillable = [
        'class_request_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    public function classRequest()
    {
        return $this->belongsTo(ClassRequest::class);
    }
}
