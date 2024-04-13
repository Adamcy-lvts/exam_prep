<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionInstruction extends Model
{
    use HasFactory;

    protected $fillable = ['instrcution'];


    public function questions()
    {
        return $this->hasMany(Question::class, 'question_instruction_id');
    }
}
