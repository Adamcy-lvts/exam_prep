<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use App\Models\TopicPerformance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'quiz_session_id', 'start_time', 'end_time', 'score'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function topicPerformances()
    {
        return $this->hasMany(TopicPerformance::class);
    }
}
