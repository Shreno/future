<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice_order extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'invoice_id', 'order_id'
    ];

    
  
}
