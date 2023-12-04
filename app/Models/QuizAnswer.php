<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'quiz_attempt_id', 'question_id', 'option_id', 'correct', 'answer_text', 'completed'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
