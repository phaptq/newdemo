<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Post_data extends Model {
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = array('post_id', 'column', 'type', 'data', 'order', 'ticker', 'date', 'created_at', 'updated_at', 'deleted_at');

    public function post() {
        return $this->hasOne('\App\Models\Post', 'id', 'post_id');
    }
}