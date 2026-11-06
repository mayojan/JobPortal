<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar_path', // فیلد آپلود عکس  
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    //  روابط Eloquent 
    public function candidate()
    {
        return $this->hasOne(Candidate::class, 'user_id');
    }

    public function employer()
    {
        return $this->hasOne(Employer::class, 'user_id');
    }

    // --- هفته هشتم: اکسسور هوشمند (Accessor) برای عکس پروفایل ---
    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->avatar_path 
                ? Storage::disk('public')->url($this->avatar_path) 
                : 'https://gravatar.com' . md5(strtolower(trim($this->email))) . '?d=mp',
        );
    }
}
