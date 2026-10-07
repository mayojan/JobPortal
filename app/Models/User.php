<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed', // لاراول ۱۱ پسوردها را خودکار هش می‌کند
    ];

    // روابط قبلی شما (candidate و employer) در زیر این خطوط باقی بمانند...
    public function candidate()
    {
        return $this->hasOne(Candidate::class, 'user_id');
    }

    public function employer()
    {
        return $this->hasOne(Employer::class, 'user_id');
    }
}
