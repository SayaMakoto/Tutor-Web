<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
   use SoftDeletes;

   protected $fillable = ['name', 'sort_order', 'status', 'is_approved'];

   public function subjects()
   {
      return $this->belongsToMany(Subject::class);
   }
}