<?php

namespace App\Models;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'module_id',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    function module()
    {
        return $this->belongsTo(Module::class);
    }
}
