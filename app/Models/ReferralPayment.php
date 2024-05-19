<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralPayment extends Model
{
    use HasFactory;

    protected $fillable = ['referral_id','amount','status','payment_date'];
}
