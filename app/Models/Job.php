<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'deadline',
    ];

    //  روابط Eloquent 
    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id', 'employer_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'job_id', 'job_id');
    }

    // مادل اسکوپ‌ها (Scopes)  
    public function scopeSearch($query, $term)
    {
        return $query->when($term, function ($q) use ($term) {
            $q->where(function ($inner) use ($term) {
                $inner->where('job_title', 'like', "%{$term}%")
                      ->orWhere('description', 'like', "%{$term}%");
            });
        });
    }

    public function scopeLocation($query, $location)
    {
        return $query->when($location, function ($q) use ($location) {
            $q->where('location', $location);
        });
    }

    public function scopeEmployerFilter($query, $employerId)
    {
        return $query->when($employerId, function ($q) use ($employerId) {
            $q->where('employer_id', $employerId);
        });
    }
}
