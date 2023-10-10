<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'name','email', 'phone', 'currency', 'order_number_characters',
        'terms_en', 'terms_ar'
    ];
}
