<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar', 'name', 'user_type', 'email', 'password', 'store_name','pickup_fees','over_weight_per_kilo_outside','cost_calc_status_id_outside',
        'logo', 'phone', 'website', 'bank_name', 'bank_account_number','standard_weight_outside','available_overweight_status_outside',
        'bank_swift', 'cost_inside_city', 'cost_outside_city', 'cost_reshipping', 'fees_cash_on_delivery','cost_reshipping_out_city','over_weight_per_kilo',
        'tax', 'tracking_number_characters', 'default_status_id', 'cost_calc_status_id', 'city_id',
        'cost_reshipping_calc_status_id', 'available_edit_status', 'available_delete_status','fees_cash_on_delivery_out_city', 'read_terms',
        'role_id', 'calc_cash_on_delivery_status_id', 'domain','available_overweight_status','standard_weight','available_collect_order_status',
        'merchant_id','provider','client_name','client_email','client_mobile','provider_store_owner_name',
        'provider_store_id','provider_store_name','provider_access_token','provider_refresh_token','work','work_type','payment','residence_photo','license_photo','vehicle_photo',
        'service_provider','manger_name','date','Num_vehicle','type_vehicle','Residency_number','manger_name',
        'provider_access_expiry','is_active','region_id','Payment_period','tax_Number','commercial_register','Tax_certificate','num_branches','show_report'
    ];

    //
    public function getOverWeightPerKiloOutsideAttribute($value)
    {
        // condiotn for published date is null
        if($value == null ){
            $value = 0.0;
        }
        return $value;
    }
    public function getOverWeightPerKiloAttribute($value)
    {
        // condiotn for published date is null
        if($value == null ){
            $value = 0.0;
        }
        return $value;
    }

     public function getCostReshippingOutCityAttribute($value)
    {
        // condiotn for published date is null
        if($value == null ){
            $value = 0.0;
        }
        return $value;
    }

    public function getFeesCashOnDeliveryAttribute($value)
    {
        // condiotn for published date is null
        if($value == null ){
            $value = 0.0;
        }
        return $value;
    }

    public function getPickupFeesAttribute($value)
    {
        // condiotn for published date is null
        if($value == null ){
            $value = 0.0;
        }
        return $value;
    }

    public function getStandardWeightAttribute($value)
    {
        // condiotn for published date is null
        if($value == null ){
            $value = 0.0;
        }
        return $value;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function ordersDelegate()
    {
        return $this->hasMany(Order::class, 'delegate_id');
    }
    public function transactions()
    {
        return $this->hasMany(ClientTransactions::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
