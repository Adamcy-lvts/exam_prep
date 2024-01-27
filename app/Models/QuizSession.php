<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use App\Models\QuizAttempt;
use App\Models\CompositeQuizSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizSession extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'quizzable_type', 'quizzable_id', 'start_time', 'duration', 'allowed_attempts', 'completed'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function compositeQuizSession()
    {
        return $this->belongsTo(CompositeQuizSession::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function quizAttempts() {
        return $this->hasMany(QuizAttempt::class);
    }

    public function quizzable()
    {
        return $this->morphTo();
    }
}
