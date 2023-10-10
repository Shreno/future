<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class OrderDelegateResource extends JsonResource
{
    
    public function toArray($request)
    {
        $user = Auth::user();
        return [
            'id'                                => $this->id,
            'order_id'                          => $this->order_id,
            'tracking_number'                   => $this->tracking_id,
            'store'                             => $this->user->store_name,
            'store_phone'                       => $this->sender_phone,
            'store_email'                       => $this->user->email,
            'client_name'                       => $this->receved_name,
            'client_phone'                      => $this->receved_phone,
            'client_email'                      => $this->receved_email,
            'client_city'                       => $this->recevedCity->title,
            'client_address'                    => $this->receved_address,
            'address_details'                   => $this->receved_address_2,
            'amount'                            => $this->amount,
            'order_status'                      => $this->status->title,

            'pickup_date'                       => $this->pickup_date,
            'available_collect_order_status'    =>$this->available_collect_order_status,
            'number_count'                      =>$this->number_count,
            'reference_number'                  =>$this->reference_number,
            'order_contents'                    =>$this->order_contents,
            'call_count'                        =>$this->call_count,
            'whatApp_count'                     =>$this->whatApp_count,
            'is_finished'                       =>$this->is_finished,
            'amount_paid'                       =>$this->amount_paid,
            'order_weight'                      =>$this->order_weight,
            'over_weight_price'                 =>$this->over_weight_price,
            'cost_reshipping_out_city'          =>$this->cost_reshipping_out_city,
        ];
    }
}
