<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\User;
use App\Models\QuizSession;
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
        return $this->belongsTo(FieldOfStudy::class, 'field_id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->exam->exam_name} - {$this->name}";
    }

    public function questions()
    {
        return $this->morphMany(Question::class, 'quizzable');
    }

    public function quizAttempt()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function quizzes()
    {
        return $this->morphMany(Quiz::class, 'quizzable');
    }
    // Inside your Subject model

    public function topics()
    {
        return $this->hasMany(SubjectTopic::class)->orderBy('order');
    }

    public function quizSessions()
    {
        return $this->morphMany(QuizSession::class, 'quizzable');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }


}
