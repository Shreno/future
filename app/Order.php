<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $dates = ['pickup_date', 'created_at'];
    protected $fillable = [
        'order_id','user_id', 'tracking_id', 'sender_city', 'sender_phone', 'sender_address', 'sender_address_2',
        'pickup_date', 'sender_notes','available_collect_order_status','number_count','reference_number',
        'receved_name','receved_phone', 'receved_email', 'receved_city', 'receved_address', 'receved_address_2',
        'receved_notes', 'status_id', 'delegate_id','order_contents', 'amount', 'call_count', 'whatApp_count',
        'is_finished', 'amount_paid','order_weight','over_weight_price','cost_reshipping_out_city',
        'sender_email','sender_name','is_returned','work_type','branch_id','region_id','longitude','latitude'
    ];

    public function dateFormatted($filedDate = "created_at", $showTimes = false)
    {
        $format = "Y-m-d";
        if($showTimes) $format = $format . " h:i:s a";
        return $this->$filedDate->format($format);

    }
    public function getWhatsappRateLinkAttribute()
    {
        $message = "عميلنا العزيز : $this->receved_name %0a سعدنا بخدمتك، وتقييمك يهمنا ويساعدنا نرجوا منك التقييم من خلال الرابط %0a $this->rate_link" ;

        $mobile = $this->receved_phone;

        if (substr($mobile, 0, 2) === '05')
        {
            $mobile = ltrim($mobile, '0');
            $mobile = '+966'.$mobile;
        }

        if (substr($mobile, 0, 2) === '96')
        {
            $mobile = ltrim($mobile, '0');
            $mobile = '+'.$mobile;
        }

        return 'https://api.whatsapp.com/send?phone=' . $mobile . '&text=' . $message;

    }

    public function getRateLinkAttribute()
    {
        return url('/order/rate/'.$this->order_id.'/'.$this->receved_phone);


    }
     public function invoice()
    {
        return $this->belongsTo(Invoice_order::class, 'order_id');
    }
    public function getDateAttribute()
    {
        // condiotn for published date is null
        return is_null($this->created_at)? "" :  $this->created_at->diffForHumans();
    }
    public function scopeNotFinshed($query)
    {
        return $query->where('is_finished', 0);
    }
    public function scopeFinshed($query)
    {
        return $query->where('is_finished', 1);
    }
    public function scopeNotDelegatedRes($query)
    {
        return $query->where('delegate_id', null)->where('work_type',2);
    }
     public function scopeNotDelegated($query)
    {
        return $query->where('delegate_id', null)->where('work_type',1);
    }
    public function scopePickupToday($query)
    {
        return $query->whereDate('pickup_date', date('Y-m-d'));
    }
    public function scopeCreatedToday($query)
    {
        return $query->whereDate('created_at', date('Y-m-d'));
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function delegate()
    {
        return $this->belongsTo(User::class, 'delegate_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function getNotificationNoAttribute( )
    {
        $user = auth()->user();
        $id  = $this->id;

        $notifications = Notification::where('order_id',$id)
            ->where('title','NOT LIKE','طلب شحن جديد')

            ->count();

        /*->where( function($q) use($user) {
            $q->where('notification_to_type', 'admin');

            $q->orWhere('notification_from', $user->id);

        })*/
        return $notifications;
    }

    public function history()
    {
        return $this->hasMany(OrderHistory::class);
    }
    public function getClientStatusAttribute()
    {
        $statusFound = OrderHistory::where('order_id',$this->id)->pluck('status_id')->toArray();
        if (count($statusFound) < 0) {
            $status = Status::where('id',$this->status_id)->first();
        }else{
            $status_id = Status::where('client_appear',1)->whereIn('id',$statusFound)->pluck('id')->toArray();

            $statusData = OrderHistory::where('order_id',$this->id)->whereIn('status_id',$status_id)->orderBy('id','desc')->first();
            if (! $statusData) {
                $status = Status::where('id',$this->status_id)->whereIn('id',$status_id)->first();
            }else{
                $status = Status::where('id',$statusData->status_id)->first();
            }
        }
        return $status;
    }

    public function clienthistory()
    {
        $status_id = Status::where('client_appear',1)->pluck('id')->toArray();
        return $this->hasMany(OrderHistory::class)->whereIn('status_id',$status_id);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function senderCity()
    {
        return $this->belongsTo(City::class, 'sender_city');
    }
    public function recevedCity()
    {
        return $this->belongsTo(City::class, 'receved_city');
    }

    public function providerOrder()
    {
        return $this->hasOne(ProviderOrder::class);
    }

    public function getRouteKeyName()
    {
        return 'order_id';
    }
}
