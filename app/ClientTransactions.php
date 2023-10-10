<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientTransactions extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id','description', 'debtor', 'creditor', 'order_id','trans_type','transaction_status'
    ];
    
   // protected $fillable = ['order'];
    
    
    public function dateFormatted($filedDate = "created_at", $showTimes = false)
    {
        $format = "Y-m-d";
        if($showTimes) $format = $format . " h:i:s a";
        return $this->$filedDate->format($format);

    }

    public function getOrderAttribute()
    {
        return Order::where('id',$this->order_id)->first();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
