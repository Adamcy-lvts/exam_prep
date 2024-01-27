<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'duration','quizzable_id','quizzable_type', 'total_marks', 'total_questions', 'max_attempts', 'additional_config'];

    public function quizzable()
    {
        return $this->morphTo();
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    
}
