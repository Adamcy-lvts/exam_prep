<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use App\Models\Question;
use App\Models\QuizAnswer;
use App\Models\TopicPerformance;
use App\Models\CompositeQuizSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','composite_quiz_session_id', 'quiz_id', 'quiz_session_id', 'start_time', 'end_time', 'score'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    function quizAnswers() {
        return $this->hasMany(QuizAnswer::class);
    }


    public function topicPerformances()
    {
        return $this->hasMany(TopicPerformance::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'quiz_attempt_questions');
    }

    public function compositeQuizSession()
    {
        return $this->belongsTo(CompositeQuizSession::class);
    }


}
