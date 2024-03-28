<?php

namespace App\Models;

use App\Models\User;
use App\Models\Topic;
use App\Models\Option;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\TopicQuizAttempt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','topic_id', 'quiz_attempt_id', 'topic_quiz_attempt_id', 'question_id', 'option_id', 'correct', 'answer_text', 'completed'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    function quizAttempt() {
        return $this->belongsTo(QuizAttempt::class);
    }

    public function topicQuizAttempt()
    {
        return $this->belongsTo(TopicQuizAttempt::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

}
