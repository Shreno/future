<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class OrderClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = Auth::user();
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'tracking_number' => $this->tracking_id,
            // 'store' => $this->user->store_name,
            // 'store_phone' => $this->sender_phone,
            // 'store_email' => $this->user->email,
            // 'ship_date' => $this->dateFormatted($this->pickup_date),
             'ship_date' => $this->pickup_date,

            'client_name' => $this->receved_name,
            'client_phone' => $this->receved_phone,
            'client_email' => $this->receved_email,
            'client_city' => $this->recevedCity->title,
            'client_address' => $this->receved_address,
            'address_details' => $this->receved_address_2,
            'amount' => $this->amount,
            'order_status' => $this->status->title
        ];
    }
}
