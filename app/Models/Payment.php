<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','amount','method','plan_id', 'attempts_purchased', 'card_type','bank', 'last_4_digits', 'status', 'authorization_code', 'transaction_id'];

}
