<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class WebSetting extends Model
{
    protected $fillable = [
        'title_en','title_ar', 'logo', 'description_en', 'description_ar', 'email', 'phone',
        'address_en','address_ar', 'about_title_en', 'about_title_ar', 'about_description_en', 'meta_keywords', 'about_description_ar',
        'image','facebook', 'twitter', 'instgram', 'youtube', 'longitude', 'latitude', 'google_analytics_id','overweight_price','standard_weight'
    ];
    public function Trans($text)
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $column = $text . '_' . $locale;
        return $this->{$column};
    }
}
