<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Post extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = array('title', 'title_ascii', 'slug', 'user_id', 'category_id', 'static', 'order', 'viewed', 'description', 'content', 'seo', 'online', 'status', 'created_at', 'updated_at');

    public function data() {
        return $this->hasOne('\App\Models\Post_data', 'post_id', 'id');
    }

    public function category() {
        return $this->hasOne('\App\Models\Category', 'id', 'category_id');
    }
}
