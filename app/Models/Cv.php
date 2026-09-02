<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    protected $primaryKey = 'cv_id';
    protected $fillable = [
        'candidate_id',
        'file_path',
    ];
}
