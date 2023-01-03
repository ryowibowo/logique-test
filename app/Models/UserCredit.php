<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCredit extends Model
{
    protected $table = 'user_credits';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'creditcard_type','creditcard_number','creditcard_name','creditcard_expired','creditcard_cvv'
    ];

} 