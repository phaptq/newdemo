<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Live_data extends Model {
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = array('title', 'slug', 'daily', 'hourly', 'daily_date', 'hourly_time', 'data', 'order', 'created_at', 'updated_at', 'deleted_at');

}