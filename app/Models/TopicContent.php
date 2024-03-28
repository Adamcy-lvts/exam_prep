<?php

namespace App\Models;

use App\Models\Topic;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TopicContent extends Model
{
    use HasFactory;

    protected $fillable = ['subject_id', 'topic_id', 'description', 'learning_objectives', 'key_concepts', 'real_world_application', 'content'];

    protected $casts = [
        'learning_objectives' => 'array', // This will automatically decode JSON into a PHP array
        'key_concepts' => 'array',
        'real_world_application' => 'array'
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
