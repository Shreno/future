<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Category extends Model
{
    protected $fillable = [
        'title_en','title_ar', 'slug'
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

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
