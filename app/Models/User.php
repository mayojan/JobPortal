<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'password',
        'role',
    ];
    public function candidate(){
        return $this->hasOne(Candidate::class, 'user_id');
    }
    public function employer(){
        return $this->hasOne(Employer::class, 'user_id');
    }
}