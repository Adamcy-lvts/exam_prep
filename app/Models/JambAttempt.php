<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JambAttempt extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'attempts_left'];
}
