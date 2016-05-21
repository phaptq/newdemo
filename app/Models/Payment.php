<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Payment extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = array('slug', 'data', 'status', 'created_at', 'updated_at', 'deleted_at');

}
