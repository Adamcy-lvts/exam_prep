<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'duration', 'total_marks', 'max_attempts'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function quizAttempt()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
