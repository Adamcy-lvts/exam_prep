<?php

namespace App\Models;

use App\Models\User;
use App\Models\Topic;
use App\Models\QuizAnswer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TopicQuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','topic_id','start_time', 'score','passed','completed'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function quizAnswers()
    {
        return $this->hasMany(QuizAnswer::class);
    }

}
