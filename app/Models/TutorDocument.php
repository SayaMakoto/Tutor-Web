<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TutorDocument extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'tutor_id',
        'file_path',
        'type',
    ];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function getTypeLabelAttribute()
    {
        return match ($this->type) {
            'additional' => 'Tài liệu bổ sung',
            default => 'Tài liệu',
        };
    }
}