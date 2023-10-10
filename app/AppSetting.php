<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'name','email', 'phone', 'currency', 'order_number_characters',
        'terms_en', 'terms_ar','term_en_res','term_ar_res','term_en_d_1','term_ar_d_1','term_en_d_2','term_ar_d_2',
    ];
}
