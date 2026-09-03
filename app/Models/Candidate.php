<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory;
    protected $primaryKey = 'candidate_id';

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'address',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cv(){
        return $this->hasOne(Cv::class, 'candidate_id');
    }
    public function applications(){
        return $this->hasMany(Application::class, 'candidate_id');
    }
}
