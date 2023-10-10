<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\Order;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
  

    //order_notification

    public function order_notification( $id)
    {
        $user = auth()->user();
        $order = Order::where('id',$id)->first();
        $notifications = Notification::where('order_id',$id)
            ->where('title','NOT LIKE','طلب شحن جديد')->orderBy('order_id','DESC')->paginate(15);
            /*
            
            ->where( function($q) use($user) {
            $q->where('notification_to_type', 'admin');

            $q->orWhere('notification_from', $user->id);
            
        })
        */
        
        return view('notifications.order', compact('notifications','order'));
    }
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($request->exists('unread') || !$request->exists('readable')) {
            if ($user->user_type == 'admin') {
                $notifications = Notification::where('title','NOT LIKE','طلب شحن جديد')->where( function($q) use($user) {
                    $q->where('notification_to_type', 'admin');

                    $q->orWhere('notification_from', $user->id);
                })
                ->Unread()
               
                ->orderBy('order_id','DESC')
                ->paginate(15);
            } else {
                $notifications = Notification::where( function($q) use($user) {
                    $q->where('notification_to', $user->id);
                    $q->orWhere('notification_from', $user->id);
                })
                ->Unread()
                
                ->orderBy('order_id','DESC')
                ->paginate(15);
            }
        } elseif($request->exists('readable')) {
            if ($user->user_type == 'admin') {
                $notifications = Notification::where('title','NOT LIKE','طلب شحن جديد')->where( function($q) use($user) {
                    $q->where('notification_to_type', 'admin');
                    $q->orWhere('notification_from', $user->id);
                })
                ->read()
               
                ->orderBy('order_id','DESC')
                ->paginate(15);
            } else {
                $notifications = Notification::where( function($q) use($user) {
                    $q->where('notification_to', $user->id);
                    $q->orWhere('notification_from', $user->id);
                })
                ->read()
           
                ->orderBy('order_id','DESC')
                ->paginate(15);
            }
        }

        return view('notifications.index', compact('notifications'));
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        Notification::create($request->all());
        $notification = array(
            'message' => '<h3>Send Successfully</h3>',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    
    public function show($id)
    {
        $user = auth()->user();
        if ($user->user_type == 'admin') {
            $notification = Notification::where('id', $id)->where( function($q) use($user) {
                    $q->where('notification_to_type', 'admin');
                    $q->orWhere('notification_from', $user->id);
                })->first();
            if ($notification) {
                $notification->update(['is_readed'=> 1]);
            }
            return view('notifications.show', compact('notification'));
        } else {
            $notification = Notification::where('id', $id)->where( function($q) use($user) {
                    $q->where('notification_to', $user->id);
                    $q->orWhere('notification_from', $user->id);
                })->first();
            if ($notification) {
                $notification->update(['is_readed'=> 1]);
            }
            return view('notifications.show', compact('notification'));
        }
        abort(404);
    }

    
    public function edit($id)
    {
        //
    }
    public function unread($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_readed'=> 0]);
        return redirect()->route('notifications.index');
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
