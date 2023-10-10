<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title', 'description', 'color','delegate_appear','restaurant_appear','shop_appear',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'status_id');
    }
}
