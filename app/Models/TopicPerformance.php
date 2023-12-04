<?php

namespace App\Models;

use App\Models\Topic;
use App\Models\QuizAttempt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TopicPerformance extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_attempt_id', 'topic_id', 'correct_answers_count', 'questions_count'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function quizAttempt()
    {
        return $this->belongsTo(QuizAttempt::class);
    }
}
