<?php

namespace App\Models;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','topic_id', 'quiz_attempt_id', 'question_id', 'option_id', 'correct', 'answer_text', 'completed'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
