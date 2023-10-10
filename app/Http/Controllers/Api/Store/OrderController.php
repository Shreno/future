<?php

namespace App\Http\Controllers\Api\Store;

use App\AppSetting;
use App\City;
use App\Address;
use App\Helpers\Notifications;
use App\Helpers\OrderHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CitiesResource;
use App\Http\Resources\OrderClientResource;
use App\Http\Resources\OrderHistoryResource;
use App\Order;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\SearchResource;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index(Request $request)
    {
        // $host = request()->getHost();
        $user = Auth::user();
        if ($user->user_type == 'client') {
            // $host = request()->getHttpHost();
            $host = request()->header('Referer');
//            return $request->header('Referer');
            if ($user->domain == $host) {
                $listOrders = OrderClientResource::collection($user->orders()->get());
                if (count($listOrders) == 0) {
                    return response()->json(["message" => "No Orders found"]);
                }
                return response()->json($listOrders);
            } else {
                return response()->json([
                    'message' => 'Invalid Authentication',
                ], 503);
            }
        } else {
            return response()->json([
                'message' => 'Invalid Authentication',
            ], 503);
        }
    }
    public function store(Request $request)
    {
        // $host = request()->getHost();
        $user = Auth::user();
        if ($user->user_type == 'client') {
            // $host = request()->getHttpHost();
//            $host = request()->getHost();
            $host = request()->header('Referer');
            if ($user->domain == $host) {
                $rules = [
                    'sender_city'                       => 'required|numeric',
                    'sender_phone'                      => 'required|numeric',
                    'sender_address'                    => 'required|min:10',
                    'sender_address_2'                  => 'required|min:10',
                    'pickup_date'                       => 'required|date|date_format:Y-m-d|after:yesterday',
                    'receved_name'                      => 'required|min:5',
                    'receved_phone'                     => 'required|numeric',
                    'receved_city'                      => 'required|numeric',
                    'receved_address'                   => 'required|min:10',
                    'receved_address_2'                 => 'required|min:10',
                    'order_contents'                    => 'required',
                ];
                $validator = Validator::make($request->all(), $rules);


                if ($validator->fails()) {
                    // Validation failed
                    return response()->json([
                        'message' => $validator->messages(),
                    ]);
                }

                $appSetting = AppSetting::findOrFail(1);
                $user = Auth()->user();
                $orderData = $request->all();
                $order = new Order();
                $lastOrderID = $order->withTrashed()->orderBy('id', 'DESC')->pluck('id')->first();
                $newOrderID = $lastOrderID + 1;
                $newOrderID = sprintf("%07s", $newOrderID);
                $orderId = $appSetting->order_number_characters . $newOrderID;
                $orderData['order_id'] = $orderId;
                $trackId = $user->tracking_number_characters . '-' . uniqid();
                $orderData['tracking_id'] = $trackId;
                $orderData['status_id'] = $user->default_status_id;

                $savedOrder =  $user->orders()->create($orderData);
                OrderHistory::addToHistory($savedOrder->id, $savedOrder->status->title, $savedOrder->status->description,$user->default_status_id);
                Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد برقم  : '.$savedOrder->order_id, 'order', null, 'admin');
                return response()->json([
                    'message' => 'Save Successfully',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Invalid Authentication',
                ], 503);
            }
        } else {
            return response()->json([
                'message' => 'Invalid Authentication',
            ], 503);
        }
    }
    
     public function Resturant_order(Request $request)
    {
        // $host = request()->getHost();
        $user = Auth::user();
        if ($user->user_type == 'client') {
            // $host = request()->getHttpHost();
//            $host = request()->getHost();
            $host = request()->header('Referer');
            if ($user->domain == $host) {
                $rules = [
                    'branch_id'                    => 'required',
                    'receved_name'                      => 'required|min:5',
                    'receved_phone'                     => 'required|numeric',
                    'region_id'                      => 'required|numeric',
                    'receved_address'                   => 'required|min:10',
                    'longitude'                    => 'required',
                    'latitude'                    => 'required',
                    'amount'                    =>'required',
                    'amount_paid'                =>'required',


                ];
                $validator = Validator::make($request->all(), $rules);


                if ($validator->fails()) {
                    // Validation failed
                    return response()->json([
                        'message' => $validator->messages(),
                    ]);
                }
                $branch=Address::find($request->branch_id);


                $appSetting = AppSetting::findOrFail(1);
                $user = Auth()->user();
                $orderData = $request->all();
                $order = new Order();
                $lastOrderID = $order->withTrashed()->orderBy('id', 'DESC')->pluck('id')->first();
                $newOrderID = $lastOrderID + 1;
                $newOrderID = sprintf("%07s", $newOrderID);
                $orderId = $appSetting->order_number_characters . $newOrderID;
                $orderData['order_id'] = $orderId;
                $trackId = $user->tracking_number_characters . '-' . uniqid();
                $orderData['tracking_id'] = $trackId;
                $orderData['status_id'] = 1;
                $orderData['branch_id'] = $branch->id;
                $orderData['sender_city'] = $branch->city_id;
                $orderData['sender_phone'] = $branch->phone;
                $orderData['sender_address'] = $branch->address;
                $orderData['work_type'] = 2;


               



                $savedOrder =  $user->orders()->create($orderData);
                OrderHistory::addToHistory($savedOrder->id, $savedOrder->status->title, $savedOrder->status->description,$user->default_status_id);
                Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد برقم  : '.$savedOrder->order_id, 'order', null, 'admin');
                return response()->json([
                    'message' => 'Save Successfully',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Invalid Authentication',
                ], 503);
            }
        } else {
            return response()->json([
                'message' => 'Invalid Authentication',
            ], 503);
        }
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }
    public function order_tracking(request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'client') {
            if ($request->tracking_number) 
            {
                $trackId=$request->tracking_number;

                $order = Order::where('tracking_id', $trackId)->first();
                if ($order) 
                {
                     $orderDetails = $order;
                    $orderHistory = OrderHistoryResource::collection($order->history()->get());

                    return response()->json($orderHistory);

                
                }
                else
                {
                    return response()->json([
                        'message' => 'There is no order for'.$trackId.'',
                    ], 503);    
                }
            }
            else
            {
                return response()->json([
                    'message' => 'Should insert Tracking id',
                ], 503);        
            }
        }
        else
        {
            return response()->json([
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }

    public function search(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'client') {
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
                ->Where('user_id', $user->id)
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
    
    // 

    public function Daily()
    {
        $user = Auth::user();
        if ($user->user_type == 'client') {
            $listOrders = OrderClientResource::collection($user->orders()->whereDate('updated_at',Carbon::now())->get());
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
    // 


}
