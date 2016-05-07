<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    protected $fillable = array('user_id', 'able', 'able_id', 'status', 'content', 'order', 'created_at', 'updated_at', 'deleted_at');

    public function comments() {
        return $this->hasMany('\App\Models\Comment', 'able_id')->where(['able' => 'comment']);
    }
    function user(){
        return $this->hasOne('\App\Models\User', 'id', 'user_id');
    }
}
