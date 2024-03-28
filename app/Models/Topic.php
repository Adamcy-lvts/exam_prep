<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\User;
use App\Models\TopicContent;
use App\Models\TopicPerformance;
use App\Models\TopicQuizAttempt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'topicable_type','topicable_id', 'unit_id', 'order'];

    public function content()
    {
        return $this->hasOne(TopicContent::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function quizAttempts()
    {
        return $this->hasMany(TopicQuizAttempt::class);
    }
    
    public function topicPerformances()
    {
        return $this->hasMany(TopicPerformance::class);
    }

    public function topicable()
    {
        return $this->morphTo();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'topic_users')
        ->withPivot('unlocked')
        ->withTimestamps();
    }




    /**
     * Get the unit that the topic belongs to.
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
