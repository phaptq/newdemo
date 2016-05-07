<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Backend_user extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use SoftDeletes;
    // protected $dates = ['deleted_at'];
    protected $fillable = [
        'name', 'email', 'password', 'group_id', 'status', 'avatar_id', 'area', 'remember_token', 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    function group(){
        return $this->hasOne('\App\Models\User_group', 'id', 'group_id');
    }
}
