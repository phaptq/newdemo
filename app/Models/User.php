<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name', 'email', 'password', 'group_id', 'status', 'avatar_id', 'third_party', 'third_party_id', 'info', 'remember_token', 'created_at', 'updated_at', 'deleted_at', 'third_party_date', 'price_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
