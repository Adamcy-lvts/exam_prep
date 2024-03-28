<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = ['faculty_name', 'code', 'description'];


    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
