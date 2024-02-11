<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'type', 'description','features','price','validity_days','number_of_attempts','plan_basis', 'cto','currency'];
}
