<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;
    protected $primaryKey = 'application_id';

    protected $fillable = [
        'job_id',
        'candidate_id',
        'status',
    ];
    public function job(){
        return $this->belongsTo(Job::class, 'job_id');
    }
    public function candidate(){
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }
}
