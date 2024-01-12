<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FieldOfStudy extends Model
{
    use HasFactory;

    protected $fillable = ['field_name','description'];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'field_id');
    }
}
