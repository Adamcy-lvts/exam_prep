<?php

namespace App\Models;

use App\Models\Topic;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'course_id', 'marks', 'type', 'answer_text', 'topic_id'];

    const TYPE_MCQ = 'mcq';
    const TYPE_SAQ = 'saq';
    const TYPE_TF = 'tf';


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
}
