<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Article extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = array('category_id', 'title','title_ascii', 'online', 'status', 'seo', 'slug', 'viewed', 'description', 'content', 'created_at', 'updated_at', 'deleted_at');
    protected $guarded = ['id', '_token'];

    public function images() {
        return $this->hasMany('\App\Models\Image', 'item_id')->where(['type' => 'content', 'item_type' => 'article']);
    }

    function thumb(){
        return $this->hasOne('\App\Models\Image', 'item_id')->where(['type' => 'thumb', 'item_type' => 'article']);
    }

    public function tags() {
        return $this->belongsToMany('\App\Models\Tags', 'article_tags', 'article_id', 'tag_id');
    }

    public function category() {
        return $this->hasOne('\App\Models\Category', 'id', 'category_id');
    }

    public function comments() {
        return $this->hasMany('\App\Models\Comment', 'able_id')->where(['able' => 'article'])->with('comments');
    }
}
