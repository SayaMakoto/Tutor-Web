<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'gender',
        'email',
        'password',
        'role',
        'avatar',
        'date_of_birth'
    ];

    public function tutor()
    {
        return $this->hasOne(Tutor::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /** Lấy ví, tự tạo nếu chưa có */
    public function getOrCreateWallet(): Wallet
    {
        return $this->wallet ?? $this->wallet()->create([
            'balance' => 0, 'frozen_balance' => 0, 'total_topped_up' => 0,
        ]);
    }
}