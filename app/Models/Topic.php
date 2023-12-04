<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\TopicPerformance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'course_id', 'unit_id'];


    public function topicPerformances()
    {
        return $this->hasMany(TopicPerformance::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
