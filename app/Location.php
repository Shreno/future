<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'lan', 'lat', 'delegate_id', 
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class,'delegate_id');
    }

   
}
