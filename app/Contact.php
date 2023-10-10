<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name','email', 'subject', 'message', 'is_readed'
    ];

    public function dateFormatted($filedDate = "created_at", $showTimes = false)
    {
        $format = "Y-m-d";
        if($showTimes) $format = $format . " h:i:s a";
        return $this->$filedDate->format($format);

    }
}
