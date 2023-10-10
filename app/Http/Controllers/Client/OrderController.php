<?php

namespace App\Http\Controllers\Client;

use App\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\City;
use App\Address;
use App\AppSetting;
use Webpatser\Uuid\Uuid;
use App\Helpers\OrderHistory;
use App\Helpers\Notifications;
use App\Mail\OrderEmail;
use Illuminate\Support\Facades\Mail;
use Excel;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $statuses = Status::get();
        if ($request->exists('type')){
            $from        = $request->get('from');
            $to          = $request->get('to');
            $status_id   = $request->get('status_id');
            if ($request->type == 'ship') {
                $orders = Order::whereBetween('pickup_date', [$from,$to])->where('user_id', Auth()->user()->id);
            } else {
                $orders = Order::whereBetween('created_at', [$from,$to])->where('user_id', Auth()->user()->id);
            }
            if($request->status_id != null){
                $orders->where('status_id', $status_id);
            }
            $orders = $orders->orderBy('updated_at','DESC')->get();

            return view('client.orders.index', compact('orders', 'statuses',  'from', 'to', 'status_id'));
        }elseif ($request->exists('bydate')) {
            
            $orders = Order::where('user_id', Auth()->user()->id)->orderBy('updated_at','DESC');
            $status_id          = $request->get('status_id');
            
            $bydate             = $request->get('bydate');
            
            $from               = null;
            $to                 = null;
            if(! empty($bydate) && $bydate != null){
                if($bydate == 'Today'){
                   
                    $today = (new \Carbon\Carbon)->today();
                    //dd($today);die();
                    $orders->whereDate('updated_at', $today);
                }elseif($bydate == 'Yesterday'){
                   
                    $yesterday = (new \Carbon\Carbon)->yesterday();
                    $orders->whereDate('updated_at', $yesterday);
                }elseif($bydate == 'LastMonth'){
                    $month = (new \Carbon\Carbon)->subMonth()->submonths(1);
                    $orders->whereDate('updated_at', '>', $month);
                }
                
            }
            if($request->status_id != null){
                $orders->where('status_id', $request->status_id);
            }
            $orders = $orders->orderBy('updated_at','DESC')->get();
            $statuses = Status::get();
            return view('client.orders.index', compact('orders',  'statuses','status_id','from','to'));
            
        }else{
            $orders = Order::where('user_id', Auth()->user()->id)->orderBy('updated_at','DESC')->get();

            return view('client.orders.index', compact('orders', 'statuses'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth()->user();
        $addresses = $user->addresses()->get();
        $cities = City::get();
        if($user->work==1)
        {
        return view('client.orders.add', compact('addresses', 'cities'));
       }else{
        return view('client.orders.addRest', compact('addresses', 'cities'));

       }
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'sender_city'                       => 'required',
            'receved_name'                      => 'required|min:2'
//            'receved_address'                   => 'required|min:10',
//            'receved_address_2'                 => 'required|min:10',
        ]);
        $appSetting             = AppSetting::findOrFail(1);
        $user                   = Auth()->user();
        $orderData              = $request->all();
        $order                  = new Order();
        $lastOrderID            = $order->withTrashed()->orderBy('id', 'DESC')->pluck('id')->first();
        $newOrderID             = $lastOrderID + 1;
        $newOrderID             = sprintf("%07s", $newOrderID);
        $orderId                = $appSetting->order_number_characters . $newOrderID;
        $orderData['order_id']  = $orderId;
                $orderData['work_type'] = 2;

        $trackId = $user->tracking_number_characters . '-' . uniqid();
        $orderData['tracking_id'] = $trackId;
        $orderData['status_id'] = $user->default_status_id;

        $savedOrder =  $request->user()->orders()->create($orderData);
        OrderHistory::addToHistory($savedOrder->id, $savedOrder->status->title, $savedOrder->status->description,$user->default_status_id);
      //  Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد برقم  : '.$savedOrder->order_id, 'order', null, 'admin', $savedOrder->id);
        $notification = array(
            'message' => '<h3>Save Successfully</h3>',
            'alert-type' => 'success'
        );


        $orderCount = Order::where('user_id', Auth()->user()->id)->count();
       // if($orderCount == 1 && $user->is_email_order != 1){
            // Mail::to('order@onmap.sa')->send(new OrderEmail($user));
          //  $user->is_email_order = 1;
          //  $user->save();
      //  }

        return redirect()->route('orders.index')->with($notification);
    }
    
     public function res_store(Request $request)
    {
        $request->validate([
            'sender_city'                       => 'required',
            'receved_name'                      => 'required|min:2'
//            'receved_address'                   => 'required|min:10',
//            'receved_address_2'                 => 'required|min:10',
        ]);
        $appSetting             = AppSetting::findOrFail(1);
        $user                   = Auth()->user();
        $orderData              = $request->all();
        $order                  = new Order();
        $lastOrderID            = $order->withTrashed()->orderBy('id', 'DESC')->pluck('id')->first();
        $newOrderID             = $lastOrderID + 1;
        $newOrderID             = sprintf("%07s", $newOrderID);
        $orderId                = $appSetting->order_number_characters . $newOrderID;
        $orderData['order_id']  = $orderId;
        $trackId = $user->tracking_number_characters . '-' . uniqid();
        $orderData['tracking_id'] = $trackId;
        $orderData['status_id'] = $user->default_status_id;
        $orderData['work_type'] = 2;



        $savedOrder =  $request->user()->orders()->create($orderData);
        OrderHistory::addToHistory($savedOrder->id, $savedOrder->status->title, $savedOrder->status->description,$user->default_status_id);
      //  Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد برقم  : '.$savedOrder->order_id, 'order', null, 'admin', $savedOrder->id);
        $notification = array(
            'message' => '<h3>Save Successfully</h3>',
            'alert-type' => 'success'
        );


        $orderCount = Order::where('user_id', Auth()->user()->id)->count();
       // if($orderCount == 1 && $user->is_email_order != 1){
            // Mail::to('order@onmap.sa')->send(new OrderEmail($user));
          //  $user->is_email_order = 1;
          //  $user->save();
      //  }

        return redirect()->route('orders.index')->with($notification);
    }
    
    

    public function show($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth()->user()->id)
            ->first();
        if ($order) {
            return view('client.orders.show', compact('order'));
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth()->user()->id)
            ->first();
        if ($order) {
            $cities = City::get();
            $user = Auth()->user();
            $addresses = $user->addresses()->get();
            return view('client.orders.edit', compact('cities', 'order', 'addresses'));
        } else {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sender_city'                       => 'required',
            'sender_phone'                      => 'required|numeric',
         //   'sender_address'                    => 'required',
           // 'sender_address_2'                  => 'required',
            'pickup_date'                       => 'required',
            'receved_name'                      => 'required|min:5',
            'receved_phone'                     => 'required|numeric',
            'receved_city'                      => 'required',
          //  'receved_address'                   => 'required',
          //  'receved_address_2'                 => 'required',
        ]);

        $order = Order::findOrFail($id);
        $order->update($request->all());
        $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
        );

        return redirect()->route('orders.index')->with($notification);
    }

    public function history($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth()->user()->id)
            ->first();
        if ($order) {
            $histories = $order->clienthistory()->get();
            return view('client.orders.history', compact('histories'));
        } else {
            abort(404);
        }
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function placeـorder_excel_to_db(Request $request)
    {
        $appSetting             = AppSetting::findOrFail(1);
        $counter = 0;
        if($request->hasFile('import_file')){

            Excel::load($request->file('import_file')->getRealPath(), function ($reader)  use($appSetting,$request){
             
              //     dd($reader->toArray()[0]['receved_city'] );die();
                
                if(! empty($reader->toArray())){
                    foreach ($reader->toArray() as $row) {
                        // echo $row['receved_city'] .'<br>';
                        
                        if(  $row['receved_phone'] != ""){
                            $receved_city = City::where('title',$row['receved_city'])->first();
                          //  $sender_city = City::where('title',$row['sender_city'])->first();
                            
                            $row['number_count'] = ! empty($row['number_count']) ? $row['number_count'] : 0;
                            $user                           = Auth()->user();
                            $orderData                      = $row;
                            
                            $senderAddress =    Address::where('user_id',auth()->user()->id)->first();
                            
                            if ( $senderAddress) {
                                $orderData['sender_city']          = $senderAddress->city_id;
                                
                                $orderData['sender_phone']         = $senderAddress->phone;
                                $orderData['sender_address']         = $senderAddress->address;
                                
                            }
                            
                            /*else{
                                # code...
                                $notification = array(
                                'message' => '<h3>Imported does not stored. You must be add an address at least</h3>',
                                'alert-type' => 'danger');
                            }
                            */
                            if ( ! empty($receved_city) ) {
                                $orderData['receved_city']          = $receved_city->id;
                            }

                            $orderData['number_count']      = intval($row['number_count']);
                            $order                          = new Order();
                            $lastOrderID                    = $order->withTrashed()->orderBy('id', 'DESC')->pluck('id')->first();
                            $newOrderID                     = $lastOrderID + 1;
                            $newOrderID                     = sprintf("%07s", $newOrderID);
                            $orderId                        = $appSetting->order_number_characters . $newOrderID;
                            $orderData['order_id']          = $orderId;
                            $trackId                        = $user->tracking_number_characters . '-' . uniqid();
                            $orderData['tracking_id']       = $trackId;
                            $orderData['status_id']         = $user->default_status_id;

                            $orderData['pickup_date']         = date('y-m-d h:i:s');

                            $savedOrder                     =  $request->user()->orders()->create($orderData);

                            OrderHistory::addToHistory($savedOrder->id, $savedOrder->status->title, $savedOrder->status->description,$user->default_status_id);
                        }else{
                            $counter ++;
                        }
                    
                    }
                   // die();
                }
               
            });
        }
        if ($counter > 0) {
            # code...
            $notification = array(
            'message' => '<h3>Imported Successfully but there are some row not imported</h3>',
            'alert-type' => 'warning'
        );
        }else{
            $notification = array(
            'message' => '<h3>Imported Successfully</h3>',
            'alert-type' => 'success'
        );
        }
        
        return redirect()->back(); 
    }
    
    function array_remove_by_value($array, $value)
    {
        return array_values(array_diff($array, array($value)));
    }

    public function print_invoices(Request $request)
    {
      
       $request['order_id']=explode(",",$request['order_id'][0]);
       $request['order_id'] = $this->array_remove_by_value( $request['order_id'], 'on' );
       
       
      //  dd( $request['order_id']);die();
        $request->validate([
            'order_id' => 'required|array',
            'order_id.*' => 'required|numeric|distinct'
        ]);
        $orders = Order::whereIn('id',$request['order_id'])->get();
        //for ($i = 0; $i < $orders; $i++) {}
        return view('client.orders.print',compact('orders'));
    }
}
