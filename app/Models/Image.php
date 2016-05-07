<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    protected $fillable = array('item_type', 'item_id', 'type', 'server_id', 'file_name', 'link', 'created_at', 'updated_at', 'deleted_at');
}
