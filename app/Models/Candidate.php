<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $primaryKey = 'candidate_id';
    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'address',
    ];
}
