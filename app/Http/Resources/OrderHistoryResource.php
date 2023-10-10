<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class OrderHistoryResource extends JsonResource
{
    
    public function toArray($request)
    {
        $user = Auth::user();
        return [
            'id'                                => $this->id,
            'order_id'                          => $this->order_id,
            'status'                           => $this->status,
            'ip'                             => $this->ip,
            'longitude'                       => $this->longitude,
            'latitude'                       => $this->latitude,
            'agent'                       => $this->agent,
            'created_at'                      => $this->created_at,
            'updated_at'                      => $this->updated_at,
           
        ];
    }
}
