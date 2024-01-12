<?php

namespace App\Models;

use App\Models\SubjectTopic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubTopic extends Model
{
    use HasFactory;

    protected $fillable = ['subject_topic_id', 'title', 'content', 'syllabus'];

    public function topic()
    {
        return $this->belongsTo(SubjectTopic::class);
    }
}
