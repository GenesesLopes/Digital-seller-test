<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users_discont extends Model
{
    protected $fillable = [
        'users_id',
        'discounts_id',
        'cupom',
        'deadline',
        'created_at',
        'updated_at'
    ];
}
