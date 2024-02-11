<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectAttempt extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'subject_id', 'attempts_left'];
}
