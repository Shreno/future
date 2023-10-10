<?php


namespace App\Helpers;
use Request;
use App\Notification as Notification;


class Notifications
{


    public static function addNotification($title, $message, $notification_type, $notification_to = null, $notification_to_type = null, $orderID = null)
    {
    	$log = [];
    	$log['notification_from'] = auth()->check() ? auth()->user()->id : 1;
    	$log['title'] = $title;
    	$log['message'] = $message;
    	$log['notification_type'] = $notification_type;
    	$log['notification_to'] = $notification_to;
    	$log['notification_to_type'] = $notification_to_type;
    	$log['order_id'] = $orderID;
    	Notification::create($log);
    }


    public static function notificationLists()
    {
    	return Notification::latest()->get();
    }


}
