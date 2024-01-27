<?php

namespace App\Models;

use App\Models\CompositeQuizSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserQuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'composite_quiz_session_id'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function compositeQuizSession()
    {
        return $this->belongsTo(CompositeQuizSession::class);
    }
}
