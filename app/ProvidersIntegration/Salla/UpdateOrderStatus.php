<?php

namespace App\ProvidersIntegration\Salla;

use App\Order;
use Illuminate\Support\Facades\Storage;

class UpdateOrderStatus extends Salla
{
    public function updateStatus(Order $order)
    {
        if(! $this->isSallaOrder($order)){
            return '';
        }
        if(is_null($order->status->salla_status_code)){
            return '';
        }else{
            $sallaStatusId = $order->status->salla_status_code;
        }

        $token = $this->getAccessToken($order->user);

        $response = $this->httpClient->executePostCall($this->baseUrl,'/admin/v2/orders/'.$order->providerOrder->provider_order_id.'/status',
            json_encode(['status_id' => $sallaStatusId]),$token);

        Storage::put('sallaRequests/'.$this->nowDate.'/updateOrderStatus/'.$this->nowTime.'updateStatusRs.json',
            $response);

        if(json_decode($response)->status == 201){
            return 'success';
        }else{
            throw new \Exception;
        }

    }


    private function isSallaOrder($order)
    {
        if(! is_null($order->providerOrder)){
            if($order->providerOrder->provider_name == 'salla'){
                return true;
            }
        }

        return false;
    }
}
