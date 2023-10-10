<?php


namespace App\Helpers;
use Request;
use App\OrderHistory as OrderHistoryModel;


class OrderHistory
{


    public static function addToHistory($order_id, $status, $status_details, $status_id,$notes = null, $longitude = null,$latitude = null)
    {
    	$log = [];
    	$log['order_id'] = $order_id;
        $log['status'] = $status;
    	$log['status_id'] = $status_id;
    	$log['status_details'] = $status_details;
    	$log['notes'] = $notes;
    	$log['ip'] = Request::ip();
    	$log['longitude'] = $longitude;
    	$log['latitude'] = $latitude;
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    	$log['user_type'] = auth()->check() ? auth()->user()->user_type : 1;
    	OrderHistoryModel::create($log);
    }


    public static function orderHistoryLists()
    {
    	return OrderHistoryModel::latest()->get();
    }


}