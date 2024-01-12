<?php

namespace App\Models;

use App\Models\SubjectTopic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'field_id', 'exam_id', 'syllabus'];

    protected $casts = [
        'syllabus' => 'array',
    ];


    public function fieldOfStudy()
    {
        return $this->belongsTo(FieldOfStudy::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function quizAttempt()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    // Inside your Subject model

    public function topics()
    {
        return $this->hasMany(SubjectTopic::class)->orderBy('order');
    }

}
