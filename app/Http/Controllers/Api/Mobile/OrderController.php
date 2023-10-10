<?php

namespace App\Http\Controllers\Api\Mobile;

use App\ClientTransactions;
use App\Helpers\Notifications;
use App\Helpers\OrderHistory;
use App\Http\Resources\CommentsResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderDelegateResource;
use App\Http\Resources\SearchResource;
use App\Http\Resources\StatusesResource;
use App\Order;
use App\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $listOrders = OrderDelegateResource::collection($user->ordersDelegate()->get());
            if (count($listOrders) == 0) {
                return response()->json(["message" => "No Orders found"]);
            }
            return response()->json([
                'success' => 1,
                'Orders' =>
                    $listOrders
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }

    public function Daily()
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $listOrders = OrderDelegateResource::collection($user->ordersDelegate()->whereDate('updated_at',Carbon::now())->get());
            if (count($listOrders) == 0) {
                return response()->json(["message" => "No Orders found"]);
            }
            return response()->json([
                'success' => 1,
                'Orders' =>
                    $listOrders
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }

    public function statuses()
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $statuses = StatusesResource::collection(Status::where('delegate_appear',1)->get());
            if (count($statuses) == 0) {
                return response()->json(["message" => "No Orders found"]);
            }
            return response()->json([
                'success' => 1,
                'statuses' =>
                    $statuses

            ]);
        } else {
            return response()->json([
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }


    public function search(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $rules = [
                'order_id' => 'required|min:9',
            ];
            $validator = Validator::make($request->all(), $rules);


            if ($validator->fails()) {
                // Validation failed
                return response()->json([
                    'message' => $validator->messages(),
                ]);
            }

            $result = Order::where('order_id', $request->order_id)
                ->Where('delegate_id', $user->id)
                ->get();
            $result = SearchResource::collection($result);
            if (count($result) > 0) {
                return response()->json([
                    'success' => 1,
                    'Order' =>
                        $result
                ]);
            }
            return response()->json([
                'success' => 0,
                'message' => 'no have results for your search',
            ], 404);
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $request->validate([

                'id' => 'required|numeric',
                'status_id' => 'required|numeric'
            ]);
            $id = $request->id;
            $status_id = $request->status_id;
            $checkOrder = Order::where('id', $id)
                ->where('delegate_id', $user->id)
                ->first();
            if ($checkOrder) {
                $oldStatus = $checkOrder->status->title;
                $order = Order::findOrFail($id);
                $order->update([
                    'status_id' => $status_id
                ]);
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
              //  Notifications::addNotification('تعديل علي طلب الشحن', ' تم تغيير حالة طلب الشحن رقم  : ' . $order->order_id . ' من ' . $oldStatus . ' الي ' . $order->status->title, 'order', $order->user_id, 'client', $order->id);

                return response()->json(["message" => "change status successfully"]);
            } else {
                return response()->json(["message" => "Sorry This order not found"]);
            }
        } else {
            return response()->json([
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }

    public function comments(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $request->validate([
                'order_id' => 'required|numeric',
            ]);
            $order_id = $request->order_id;
            $order = Order::findOrFail($order_id);
            $comments = CommentsResource::collection($order->comments()->get());
            if (count($comments) == 0) {
                return response()->json([
                    'success' => 0,
                    'message' => 'No Comments found'
                ]);
            }
            return response()->json([
                'success' => 1,
                'comments' =>
                    $comments

            ]);
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }

    public function storeComment(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $request->validate([
                'order_id' => 'required|numeric',
                'comment' => 'required'
            ]);
            $order = Order::findOrFail($request->order_id);
            $comment = $user->comments()->create($request->all());
            if ($comment) {
                Notifications::addNotification('تعليق جديد', ' تم اضافة تعليق جديد علي طلب الشحن رقم  : ' . $order->order_id, 'comment', null, 'admin');
                return response()->json([
                    'success' => 1,
                    'message' => 'Save Comment Success',
                ], 200);
            }
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }

    public function contactCount(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $request->validate([
                'order_id' => 'required|numeric',
                'type' => 'required'
            ]);
            $order = Order::findOrFail($request->order_id);
            if ($request->type == 'call') {
                $update = $order->increment('call_count');

            } elseif ($request->type == 'whats') {
                $update = $order->increment('whatApp_count');

            } else {
                return response()->json([
                    'success' => 0,
                    'message' => 'Type is not correct please choose one of them (call , whats) ',
                ], 503);
            }
            if ($update) {
                return response()->json([
                    'success' => 1,
                    'message' => 'Update Success',
                ], 200);
            }
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }

    public function updateList(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $request->validate([
                'order_id' => 'required|array',
                'order_id.*' => 'required|numeric|distinct',
                'status_id' => 'required|numeric'
            ]);
            $orders = count($request['order_id']);
            for ($i = 0; $i < $orders; $i++) {

                $id = $request->order_id[$i];
                $status_id = $request->status_id;
                $checkOrder = Order::where('id', $id)
                    ->where('delegate_id', $user->id)
                    ->first();
                    $oldStatus = $checkOrder->status->title;
                    $order = Order::findOrFail($id);
                    $order->update([
                        'status_id' => $status_id
                    ]);
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
              //      Notifications::addNotification('تعديل علي طلب الشحن', ' تم تغيير حالة طلب الشحن رقم  : ' . $order->order_id . ' من ' . $oldStatus . ' الي ' . $order->status->title, 'order', $order->user_id, 'client', $order->id);
            };

            return response()->json([
                'success' => 1,
                "message" => "change status successfully"
            ]);



        } else {
            return response()->json([
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }
    public function updateListV2(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $request->validate([
                'status_id' => 'required|numeric'
            ]);

            $ordersId = $request->order_id;
            $Myorders = explode(',', $ordersId);
            $orders =  count($Myorders) ;
            for ($i = 0; $i < $orders; $i++) {
                $id = $Myorders[$i];
                $status_id = $request->status_id;
                $checkOrder = Order::where('id', $id)
                    ->where('delegate_id', $user->id)
                    ->first();
                    $oldStatus = $checkOrder->status->title;
                    $order = Order::findOrFail($id);
                    $order->update([
                        'status_id' => $status_id
                    ]);
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
                   // Notifications::addNotification('تعديل علي طلب الشحن', ' تم تغيير حالة طلب الشحن رقم  : ' . $order->order_id . ' من ' . $oldStatus . ' الي ' . $order->status->title, 'order', $order->user_id, 'client', $order->id);
            };

            return response()->json([
                'success' => 1,
                "message" => "change status successfully"
            ]);



        } else {
            return response()->json([
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }
}
