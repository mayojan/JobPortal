<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    protected $primaryKey = 'employer_id';
    protected $fillable = [
        'user_id',
        'company_name',
        'phone',
        'address',
    ];
}
