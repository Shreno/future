<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'city_id', 'address', 'description',
        'phone', 'longitude', 'latitude','region_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
      public function region()
    {
        return $this->belongsTo(Region::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
