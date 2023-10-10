<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RateOrder extends Model
{
    protected $fillable = [
        'name','mobile', 'rate','review','order_id','order_no'
    ];

    public function dateFormatted($filedDate = "created_at", $showTimes = false)
    {
        $format = "Y-m-d";
        if($showTimes) $format = $format . " h:i:s a";
        return $this->$filedDate->format($format);

    }
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
}
