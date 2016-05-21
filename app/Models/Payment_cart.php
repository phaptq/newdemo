<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Payment_cart extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = array('user_id', 'buyer', 'plan_id', 'plan', 'payment_type', 'payment_method', 'bank_code', 'total_amount', 'order_code', 'receiver_email', 'transaction_status', 'transaction_id', 'created_at', 'updated_at', 'deleted_at');

}
