<?php

namespace App\Models;

use App\Models\User;
use App\Models\Topic;
use App\Models\Module;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\QuizSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title','course_code', 'duration', 'total_marks', 'max_attempts'];


    public function quizAttempt()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function quizzes()
    {
        return $this->morphMany(Quiz::class, 'quizzable');
    }

    public function questions()
    {
        return $this->morphMany(Question::class, 'quizzable');
    }
    

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function quizSessions()
    {
        return $this->morphMany(QuizSession::class, 'quizzable');
    }


}
