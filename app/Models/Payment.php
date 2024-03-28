<?php

namespace App\Models;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','amount','method','plan_id', 'attempts_purchased', 'card_type','bank', 'last_4_digits', 'status', 'authorization_code', 'transaction_id'];

    function plan(){
        return $this->belongsTo(Plan::class);
    }

    function user(){
        return $this->belongsTo(User::class);
    }

    
}
