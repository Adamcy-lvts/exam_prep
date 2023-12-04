<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizSession extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'start_time', 'duration', 'allowed_attempts', 'completed'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
