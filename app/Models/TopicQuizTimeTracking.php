<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicQuizTimeTracking extends Model
{
    use HasFactory;

    protected $fillable = ['topic_quiz_attempt_id', 'question_id', 'user_id', 'question_start_time', 'question_end_time', 'time_spent'];
}
