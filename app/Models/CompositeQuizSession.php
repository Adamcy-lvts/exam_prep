<?php

namespace App\Models;

use App\Models\QuizAttempt;
use App\Models\QuizSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompositeQuizSession extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'duration', 'allowed_attempts', 'start_time', 'end_time', 'completed'];

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
