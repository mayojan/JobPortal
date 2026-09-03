<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cv extends Model
{
    use HasFactory;
    protected $primaryKey = 'cv_id';
    protected $fillable = [
        'candidate_id',
        'file_path',
    ];
    public function candidate(){
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }
}
