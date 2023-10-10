<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Branch extends Model
{
    protected $fillable = [
        'title_en','title_ar', 'address_en', 'address_ar', 'email', 'phone',
    ];

    public function dateFormatted($filedDate = "created_at", $showTimes = false)
    {
        $format = "Y-m-d";
        if($showTimes) $format = $format . " h:i:s a";
        return $this->$filedDate->format($format);

    }
    public function trans($text)
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $column = $text . '_' . $locale;
        return $this->{$column};
    }
}
