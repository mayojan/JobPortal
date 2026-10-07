<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;
    protected $primaryKey = 'job_id';
    protected $fillable = [
        'employer_id',
        'job_title',
        'description',
        'salary',
        'location',
        'type',
        'deadline',
    ];
    public function employer(){
        return $this->belongsTo(Employer::class, 'employer_id');
    }
    public function applications(){
        return $this->hasMany(Application::class, 'job_id');
    }
}
