<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title','city_id', 'longitude', 'latitude',
    ];
    
      public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}