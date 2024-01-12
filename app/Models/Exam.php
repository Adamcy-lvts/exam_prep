<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['exam_name', 'description'];

    public function fieldsOfStudy()
    {
        return $this->hasMany(FieldOfStudy::class);
    }
}
