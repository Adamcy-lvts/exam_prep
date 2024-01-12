<?php

namespace App\Models;

use App\Models\SubTopic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubjectTopic extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'subject_id', 'order', 'description'];

    protected $casts = [
        'learning_objectives' => 'array',
        'key_concepts' => 'array',
        'real_world_application' => 'array',
    ];


    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function subtopics()
    {
        return $this->hasMany(SubTopic::class);
    }


}
