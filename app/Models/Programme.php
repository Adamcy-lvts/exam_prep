<?php

namespace App\Models;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Programme extends Model
{
    use HasFactory;

    // add fillable
    protected $fillable = ['name'];
    
    
    public function subjects()
    {
        return $this->belongsToMany(Subject::class)->withPivot('is_default');
    }
}
