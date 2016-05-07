<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Category extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = array('title', 'slug', 'online', 'status', 'order', 'seo', 'parent_id', 'description', 'created_at', 'updated_at', 'deleted_at');

    public function items() {
        return $this->hasMany('\App\Models\Category', 'parent_id');
    }
}
