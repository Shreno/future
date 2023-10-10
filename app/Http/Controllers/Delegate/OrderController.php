<?php

namespace App\Http\Controllers\Delegate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Status;
use App\Helpers\OrderHistory;
use App\Helpers\Notifications;
use App\ClientTransactions;
use Carbon\Carbon;
class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $bydate             = $request->get('bydate');
        $status_id          = $request->get('status_id');
        
        $orders = Order::where('delegate_id', $user->id);
        if ($request->exists('shipToday')) {
        //   echo $user->id;die();
            $orders =  Order::whereDate('updated_at', date('Y-m-d'))->where('delegate_id', $user->id)->orderBy('updated_at','DESC');
          //  dd($orders);die();
        } else {
            $orders = Order::where('delegate_id', $user->id)->orderBy('updated_at','DESC');
        }
        
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
        
        $orders =  $orders->get();
        return view('delegate.orders.index', compact('orders'));
    }
    public function show($id)
    {
        $user = auth()->user();
        $order = Order::where('id', $id)->where('delegate_id', $user->id)->first();
        if ($order) {
            return view('delegate.orders.show', compact('order'));
        } else {
            abort(404);
        }
     }
    public function edit($id)
    {
        $user = auth()->user();
        $order = Order::where('id', $id)->where('delegate_id', $user->id)->first();
        if ($order) {
            $statuses = Status::where('delegate_appear',1)->whereNotIn('id', [$order->status_id])->get();
            return view('delegate.orders.edit', compact('statuses', 'order'));
        } else {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'status_id'  => 'required|numeric'
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status->title;
        $order->update($request->all());
        $order = Order::findOrFail($id);
        if ($order) {
            if ($order->status_id == $order->user->cost_calc_status_id && $order->sender_city == $order->receved_city) {
                $transaction = ClientTransactions::where('order_id', $order->id)->where('trans_type', 'cost')->first();
                if (!$transaction) {
                    if ($order->sender_city == $order->receved_city) {
                        $cost = $order->user->cost_inside_city;
                        $tax = $cost * $order->user->tax / 100;
                        $total = $cost + $tax;
                        ClientTransactions::create([
                            "user_id" => $order->user_id,
                            "description" => 'تكلفة شحن طلب رقم : ' . $order->order_id . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax,
                            "creditor" => $total,
                            "order_id" => $order->id,
                            "trans_type" => 'cost',
                        ]);
                    } else {
                        $cost = $order->user->cost_outside_city;
                        $tax = $cost * $order->user->tax / 100;
                        $total = $cost + $tax;
                        ClientTransactions::create([
                            "user_id" => $order->user_id,
                            "description" => 'تكلفة شحن طلب رقم : ' . $order->order_id . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax,
                            "creditor" => $total,
                            "order_id" => $order->id,
                            "trans_type" => 'cost',
                        ]);
                    }
                }
            }
            
            if ($order->status_id == $order->user->cost_calc_status_id_outside && $order->sender_city != $order->receved_city) {
                $transaction = ClientTransactions::where('order_id', $order->id)->where('trans_type', 'cost')->first();
                if (!$transaction) {
                    if ($order->sender_city == $order->receved_city) {
                        $cost = $order->user->cost_inside_city;
                        $tax = $cost * $order->user->tax / 100;
                        $total = $cost + $tax;
                        ClientTransactions::create([
                            "user_id" => $order->user_id,
                            "description" => 'تكلفة شحن طلب رقم : ' . $order->order_id . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax,
                            "creditor" => $total,
                            "order_id" => $order->id,
                            "trans_type" => 'cost',
                        ]);
                    } else {
                        $cost = $order->user->cost_outside_city;
                        $tax = $cost * $order->user->tax / 100;
                        $total = $cost + $tax;
                        ClientTransactions::create([
                            "user_id" => $order->user_id,
                            "description" => 'تكلفة شحن طلب رقم : ' . $order->order_id . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax,
                            "creditor" => $total,
                            "order_id" => $order->id,
                            "trans_type" => 'cost',
                        ]);
                    }
                }
            }
            if ($order->status_id == $order->user->cost_reshipping_calc_status_id) {
                $transaction = ClientTransactions::where('order_id', $order->id)->where('trans_type', 'reshipping')->first();
                if (!$transaction) {
                    
                    if ($order->sender_city == $order->receved_city) {
                        $cost = $order->user->cost_reshipping;
                    }else{
                        $cost = $order->user->cost_reshipping_out_city;
                    }
                   
                    ClientTransactions::create([
                        "user_id" => $order->user_id,
                        "description" => 'تكلفة اعادة شحن طلب رقم : ' . $order->order_id,
                        "creditor" => $cost,
                        "order_id" => $order->id,
                        "trans_type" => 'reshipping',
                    ]);
                    
                    
                    
                }
            }
            if ($order->status_id == $order->user->calc_cash_on_delivery_status_id) {
                if ($order->amount > 0) {
                    $transaction = ClientTransactions::where('order_id', $order->id)->where('trans_type', 'cash_fees')->first();
                    if (!$transaction) {
                        if ($order->sender_city == $order->receved_city) {
                            $fees = $order->user->fees_cash_on_delivery;
                        }else{
                            $fees = $order->user->fees_cash_on_delivery_out_city;
                        }
                        ClientTransactions::create([
                            "user_id" => $order->user_id,
                            "description" => 'رسوم تحصيل مبلغ مالي للطلب رقم : ' . $order->order_id,
                            "creditor" => $fees,
                            "order_id" => $order->id,
                            "trans_type" => 'cash_fees',
                        ]);
                        ClientTransactions::create([
                            "user_id" => $order->delegate_id,
                            "description" => ' تحصيل مبلغ مالي للطلب رقم : ' . $order->order_id,
                            "creditor" => $order->amount,
                            "order_id" => $order->id,
                            "trans_type" => 'amount',
                        ]);
                        ClientTransactions::create([
                            "user_id" => $order->user_id,
                            "description" => ' تحصيل مبلغ مالي للطلب رقم : ' . $order->order_id,
                            "debtor" => $order->amount,
                            "order_id" => $order->id,
                            "trans_type" => 'amount',
                        ]);
                    }
                }
            }
            if ($order->status_id == $order->user->available_overweight_status && $order->sender_city == $order->receved_city) {
                $transaction = ClientTransactions::where('order_id', $order->id)->where('trans_type', 'cost_weight')->first();
                
                if (!$transaction) {
                    $standard_weight = $order->user->standard_weight;
                    
                    //over_weight_per_kilo_outside
                    if ($order->sender_city == $order->receved_city) {
                        $standard_weight = $order->user->standard_weight;
                        $over_weight_per_kilo = $order->user->over_weight_per_kilo;
                    }else{
                        $standard_weight = $order->user->standard_weight_outside;
                        $over_weight_per_kilo = $order->user->over_weight_per_kilo_outside;
                    }
                    
                    if($over_weight_per_kilo == null){
                        $over_weight_per_kilo = 0;
                    }
                    
                    if($standard_weight == null){
                        $standard_weight = 0;
                    }
                    if( ($order->order_weight - $standard_weight ) > 0){
                        $total = ($order->order_weight - $standard_weight ) * $over_weight_per_kilo ;
                        
                        ClientTransactions::create([
                            "user_id" => $order->user_id,
                            "description" => 'تكلفة الوزن الزائد للطلب  رقم : ' . $order->order_id . ' مبلغ : ' . $total,
                            "creditor" => $total,
                            "order_id" => $order->id,
                            "trans_type" => 'cost_weight',
                        ]);
                    }
                    
                }
            }
            if ($order->status_id == $order->user->available_overweight_status_outside && $order->sender_city != $order->receved_city) {
                $transaction = ClientTransactions::where('order_id', $order->id)->where('trans_type', 'cost_weight')->first();
                
                if (!$transaction) {
                    $standard_weight = $order->user->standard_weight;
                    
                    //over_weight_per_kilo_outside
                    if ($order->sender_city == $order->receved_city) {
                        $standard_weight = $order->user->standard_weight;
                        $over_weight_per_kilo = $order->user->over_weight_per_kilo;
                    }else{
                        $standard_weight = $order->user->standard_weight_outside;
                        $over_weight_per_kilo = $order->user->over_weight_per_kilo_outside;
                    }
                    
                    if($over_weight_per_kilo == null){
                        $over_weight_per_kilo = 0;
                    }
                    
                    if($standard_weight == null){
                        $standard_weight = 0;
                    }
                    if( ($order->order_weight - $standard_weight ) > 0){
                        $total = ($order->order_weight - $standard_weight ) * $over_weight_per_kilo ;
                        
                        ClientTransactions::create([
                            "user_id" => $order->user_id,
                            "description" => 'تكلفة الوزن الزائد للطلب  رقم : ' . $order->order_id . ' مبلغ : ' . $total,
                            "creditor" => $total,
                            "order_id" => $order->id,
                            "trans_type" => 'cost_weight',
                        ]);
                    }
                    
                }
            }
            
            
            if ( $order->status_id == $order->user->available_collect_order_status ) {
               // echo 'here';die();
                $dateNowSubHour = Carbon::now()->subHours(1);
                $order_ids  = ClientTransactions::where('user_id', $order->user_id)->where('trans_type', 'cost_collect_order')
                ->whereDate('created_at','>=',$dateNowSubHour)->pluck('order_id')->toArray();
                
                if ( count($order_ids) > 0 ) {
                    
                    $order_counts = Order::whereIn('id',$order_ids)->where('user_id', $order->user_id)->where('delegate_id', $order->delegate_id)->count();
                    
                    if ($order_counts < 1 ) {
                        $total = $order->user->pickup_fees;
                        ClientTransactions::create([
                            "user_id" => $order->user_id,
                            "description" => 'تكلفه  استلام الطلبات من متجرك بمبلغ قيمته : '.$total,
                            "creditor" => $total,
                            "order_id" => $order->id,
                            "trans_type" => 'cost_collect_order',
                        ]);
                    }
                }else{
                    $total = $order->user->pickup_fees;
                    ClientTransactions::create([
                        "user_id" => $order->user_id,
                        "description" => 'تكلفه  استلام الطلبات من متجرك بمبلغ قيمته : '.$total,
                        "creditor" => $total,
                        "order_id" => $order->id,
                        "trans_type" => 'cost_collect_order',
                    ]);
                }
                
                
            }
        
            OrderHistory::addToHistory($order->id, $order->status->title, $order->status->description,$request->status_id);
          //  Notifications::addNotification('تعديل علي طلب الشحن', ' تم تغيير حالة طلب الشحن رقم  : ' . $order->order_id .' من '.$oldStatus.' الي '.$order->status->title, 'order', $order->user_id, 'client', $order->id);
            $notification = array(
                'message' => '<h3>Change Status Successfully</h3>',
                'alert-type' => 'success'
            );
        }else{
            $notification = array(
                'message' => '<h3>Sorry.. something wrong !!</h3>',
                'alert-type' => 'error'
            );
        }


        return back()->with($notification);
    }
    public function destroy($id)
    {
        //
    }
}
