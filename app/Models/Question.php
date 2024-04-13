<?php

namespace App\Models;

use App\Models\Topic;
use App\Models\Course;
use App\Models\QuestionInstruction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question','quiz_id','quizzable_id','quizzable_type', 'marks', 'type','year', 'duration','question_image','answer_text', 'topic_id', 'explanation'];

    const TYPE_MCQ = 'mcq';
    const TYPE_SAQ = 'saq';
    const TYPE_TF = 'tf';

    public function instruction()
    {
        return $this->belongsTo(QuestionInstruction::class, 'question_instruction_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function quizzable()
    {
        return $this->morphTo();
    } 

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
