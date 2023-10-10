<?php

namespace App\Http\Controllers\Admin;

use App\AppSetting;
use App\ProvidersIntegration\Salla\UpdateOrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\City;
use App\User;
use App\Helpers\Notifications;
use App\Status;
use App\Helpers\OrderHistory;
use App\ClientTransactions;

use Carbon\Carbon;
class OrderController extends Controller
{
    public function __construct()
  {
    // $this->middleware('permission:show_order', ['only'=>'index', 'show']);
    // $this->middleware('permission:distribution_order', ['only'=>'edit', 'update']);
    // $this->middleware('permission:delete_order', ['only'=>'destroy']);
  }
    public function index(Request $request)
    {
        $work_type=$request->work_type;

        $cities = City::orderBy('title', 'ASC')->get();

        if ($request->exists('notDelegated1') || $request->exists('notDelegated2') ||   $request->type == 'notDelegated' ||$request->type == 'notDelegated1'||$request->type == 'notDelegated2' ) {
          
            $sender_city        = $request->get('sender_city');

            $receved_city       = $request->get('receved_city');
            $delegates = User::where('user_type', 'delegate')->get();
            
            if($request->exists('notDelegated1')||$request->type == 'notDelegated1')
            {
            $work_type=1;
            $orders = Order::NotDelegated()->orderBy('id', 'desc');
                        $delegatedorders = Order::whereNotNull('delegate_id')->where('work_type',2)->orderBy('id', 'desc');

            }
            if($request->exists('notDelegated2')||$request->type == 'notDelegated2')
            {
                            $work_type=2;

            $orders = Order::NotDelegatedRes()->orderBy('id', 'desc');
                        $delegatedorders = Order::whereNotNull('delegate_id')->where('work_type',2)->orderBy('id', 'desc');


                
            }


            if($request->sender_city != null){
                $orders = $orders->where('sender_city', $request->sender_city);
                 $delegatedorders = $delegatedorders->where('sender_city', $request->sender_city);
            }

            if($request->receved_city != null){
               $orders = $orders->where('receved_city', $request->receved_city);
               $delegatedorders = $delegatedorders->where('receved_city', $request->receved_city);
            }

            $orders = $orders->get();

            $delegatedorders = $delegatedorders->get();
              
            return view('admin.orders.not-distributed', compact('work_type','orders', 'delegates','delegatedorders','cities','sender_city','receved_city'));



        }elseif ($request->exists('bydate')) {

            $orders = Order::orderBy('pickup_date','DESC');
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
            $orders = $orders->where('work_type',$work_type)->orderBy('id', 'desc')->paginate(50);
            $clients = User::where('user_type', 'client')->where('work',$work_type)->get();
            $delegates = User::where('user_type', 'delegate')->where('work',$work_type)->get();
            if($work_type==1)
            {
                            $statuses = Status::where('shop_appear',1)->get();

                
            }elseif($$work_type==2)
            {
                            $statuses = Status::where('restaurant_appear',1)->get();

            }
            return view('admin.orders.index', compact('orders', 'work_type','clients', 'statuses','delegates','status_id','from','to','cities'));

        }
        elseif ($request->exists('type')) {
            

            $from               = $request->get('from');
            $to                 = $request->get('to');
            $user_id            = $request->get('user_id');
            $status_id          = $request->get('status_id');
            $delegate_id        = $request->get('delegate_id');
            $contact_status     = $request->get('contact_status');

            $sender_city        = $request->get('sender_city');

            $receved_city       = $request->get('receved_city');
            $search             = $request->get('search');

            $search_order       = $request->get('search_order');


            if($from != null && $to != null){
                if ($request->type == 'ship'   ) {
                    $orders = Order::whereDate('pickup_date', '>=', $from)
                           ->whereDate('pickup_date', '<=', $to);
                } else {
                    $orders = Order::whereDate('created_at', '>=', $from)
                           ->whereDate('created_at', '<=', $to);
                }
            }else{
                $orders = Order::orderBy('pickup_date','DESC');
            }

            if( isset($search) && $search != ""){

                $columns = [
                    'order_id','user_id', 'tracking_id', 'sender_city', 'sender_phone', 'sender_address', 'sender_address_2',
                    'pickup_date', 'sender_notes','number_count','reference_number',
                    'receved_name','receved_phone', 'receved_email', 'receved_city', 'receved_address', 'receved_address_2',
                    'receved_notes', 'status_id', 'delegate_id','order_contents', 'amount', 'call_count', 'whatApp_count',
                    'is_finished', 'amount_paid','order_weight','over_weight_price'
                ];
                $orders = $orders->where(function($q) use($search,$columns) {
                    foreach($columns as $column){

                        $q->orWhere($column, 'LIKE', '%' . $search . '%');
                    }

                     $q->orWhereHas('user', function ($query) use ($search){
                        $query->where('store_name', 'LIKE', '%'.$search.'%');
                    });
                });


            }

            if( isset($search_order) && $search_order != ""){

                $search_order_array = array_map('trim',array_filter(explode(' ',$search_order)));

                $orders = $orders->where(function($q) use($search_order_array) {

                    $q->whereIn('order_id', $search_order_array);
                    $q->orWhereIn('id', $search_order_array);
                    $q->orWhereIn('reference_number', $search_order_array);


                });


            }




            if($request->sender_city != null){
                $orders->where('sender_city', $request->sender_city);
            }

            if($request->receved_city != null){
                $orders->where('receved_city', $request->receved_city);
            }
            if($request->user_id != null){
                $orders->where('user_id', $request->user_id);
            }
            if($request->status_id != null){
                $orders->where('status_id', $request->status_id);
            }
            if($request->contact_status != null){
                //call_count
                if($request->contact_status  == 0){
                    $orders->where('whatApp_count', 0)->where('call_count', 0);
                }else{
                    $orders->where(function($q){
                        $q->where(function($q1){
                            $q1->where('whatApp_count', 0);
                            $q1->where('call_count','>', 0);

                        })->orWhere(function($q2){
                            $q2->where('whatApp_count','>', 0);
                            $q2->where('call_count', 0);
                        });

                    });
                }
            }
            if($request->delegate_id != null){
                $orders->where('delegate_id', $request->delegate_id);
            }

            //bydate
            $orders = $orders->where('work_type',$work_type)->orderBy('id', 'desc')->paginate(50);
            $clients = User::where('user_type', 'client')->where('work',$work_type)->get();
            $delegates = User::where('user_type', 'delegate')->where('work',$work_type)->get();
             if($work_type==1)
            {
              $statuses = Status::where('shop_appear',1)->get();

                
            }elseif($work_type==2)
            {
             $statuses = Status::where('restaurant_appear',1)->get();

            }  
            return view('admin.orders.index', compact('orders','work_type','clients', 'statuses', 'from', 'to', 'user_id', 'status_id','delegates','contact_status','delegate_id','cities','sender_city','receved_city','search','search_order'));
        } 
        else
        {
            $orders = Order::where('work_type',$work_type)->orderBy('id', 'desc')->paginate(50);
            $clients = User::where('user_type', 'client')->where('work',$work_type)->get();
            $delegates = User::where('user_type', 'delegate')->where('work',$work_type)->get();
            if($work_type==1)
            {
              $statuses = Status::where('shop_appear',1)->get();

                
            }elseif($work_type==2)
            {
             $statuses = Status::where('restaurant_appear',1)->get();

            }
            
            return view('admin.orders.index', compact('orders','work_type', 'clients', 'statuses','delegates','cities'));
        }
    }
    
   
   
    public function show($id)
    {
        $order = Order::findOrFail($id);
        if ($order) {
            return view('admin.orders.show', compact('order'));
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
        $order = Order::findOrFail($id);
        if ($order) {
            $delegates = User::where('user_type', 'delegate')->get();
            $cities = City::get();
            $user = User::where('id',$order->user_id)->first();
            $addresses = [];
            if(! empty($user)){
                $addresses = $user->addresses()->get();
            }

            return view('admin.orders.edit', compact('delegates', 'order','addresses','user','cities'));
        } else {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
       /* $request->validate([

            'delegate_id'  => 'required|numeric'
        ]);


        $request->validate([
            'sender_city'                       => 'required',
            'sender_phone'                      => 'required|numeric',
            'sender_address'                    => 'required|min:10',
            'sender_address_2'                  => 'required|min:10',
            'pickup_date'                       => 'required',
            'receved_name'                      => 'required|min:5',
            'receved_phone'                     => 'required|numeric',
            'receved_city'                      => 'required',
            'receved_address'                   => 'required|min:10',
            'receved_address_2'                 => 'required|min:10',
        ]);

         */

        $order = Order::findOrFail($id);
        $order->update($request->all());
        $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
        );
       /* Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد الي حسابك : '.$order->order_id, 'order', $request->delegate_id, 'delegate', $order->id);
        $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
        );

        */
        return redirect()->route('client-orders.index',['work_type'=>$order->work_type])->with($notification);
    }
    public function distribute(Request $request)
    {

        $request->validate([

            'delegate_id'  => 'required|numeric',
        ]);
        $delegate_id = $request->delegate_id;

        if($request->type == 'data'){
            $orders = explode(",",$request['orders'][0]);
            $orders = $this->array_remove_by_value( $orders, 'on' );
        }else{
            $orders = $request['orders'];
        }


        if ($orders){
            foreach ($orders as $order) {

               $orderRow =  Order::where('id', $order)->first();
                $orderRow->update(["delegate_id"=>$delegate_id]);
                Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد الي حسابك : '.$orderRow->order_id, 'order', $delegate_id, 'delegate', $orderRow->id);
            }
            $notification = array(
                'message' => '<h3>Saved Successfully</h3>',
                'alert-type' => 'success'
            );
        }else{
            $notification = array(
                'message' => '<h3>you not selected any order</h3>',
                'alert-type' => 'error'
            );
        }



        return back()->with($notification);
    }

    public function history($id)
    {
        $order = Order::findOrFail($id);
        if ($order) {

            $histories = $order->history()->get();
            return view('admin.orders.history', compact('histories', 'order'));
        }else {
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

    public function createReturnOrder(Order $order)
    {
        $appSettings = AppSetting::first();
        $lastOrderID = Order::withoutTrashed()->orderBy('id', 'DESC')->pluck('id')->first();
        $newOrderID = $lastOrderID + 1;
        $lengthOfNewOrderId = strlen((string)$newOrderID);
        if($lengthOfNewOrderId < 7){
            for($i = 0; $i < 7; $i++){
                $newOrderID = '0'.$newOrderID;
            }
        }

        $orderId = $appSettings->order_number_characters . $newOrderID;

        $returnOrder = Order::create([
            'order_id' => $orderId,
            'user_id'  => $order->user_id,
            'tracking_id' => $order->user->tracking_number_characters . '-' . uniqid(),
            'number_count' => $order->number_count,
            'sender_name'  => $order->receved_name,
            'sender_email'  => $order->receved_email,
            'sender_city'   => $order->receved_city,
            'sender_phone'  => $order->receved_phone,
            'sender_address' => $order->receved_address,
            'sender_address_2' => $order->receved_address_2,
            'pickup_date'      => now()->toDateString(),
            'receved_name'     => $order->sender_name,
            'receved_phone'    => $order->sender_phone,
            'receved_email'   => $order->sender_email,
            'receved_city'    => $order->sender_city,
            'receved_address' => $order->sender_address,
            'receved_address_2' => $order->sender_address_2,
            'order_contents' => $order->order_contents,
            'amount' => $order->amount,
            'order_weight' => $order->order_weight,
            'over_weight_price' => $order->over_weight_price,
            'call_count' => $order->call_count,
            'whatApp_count' => $order->whatApp_count,
            'status_id' => $order->user->default_status_id,
            'provider' => $order->provider,
            'provider_order_id' => $order->provider_order_id,
            'is_returned' => 1
        ]);
        $order = $returnOrder;
        OrderHistory::addToHistory($returnOrder->id, $returnOrder->status->title, $returnOrder->status->description,$returnOrder->user->default_status_id);
        Notifications::addNotification('طلب شحن مرتجع', 'تم اضافة طلب شحن مرتجع جديد برقم  : '.$returnOrder->order_id, 'order', null, 'admin');

        return view('admin.orders.show', compact('order'));
    }


    //

    function array_remove_by_value($array, $value)
    {
        return array_values(array_diff($array, array($value)));
    }

    public function change_status(Request $request)
    {

       $request['order_id']=explode(",",$request['order_id'][0]);
       $request['order_id'] = $this->array_remove_by_value( $request['order_id'], 'on' );


      //  dd( $request['order_id']);die();
        $request->validate([
            'order_id' => 'required|array',
            'order_id.*' => 'required|numeric|distinct',
            'status_id' => 'required|numeric'
        ]);
        $orders = count($request['order_id']);
        for ($i = 0; $i < $orders; $i++) {

            $id = $request->order_id[$i];
            $status_id = $request->status_id;
            //$checkOrder = Order::where('id', $id)->first();
            //$oldStatus = $checkOrder->status->title;
            $order = Order::findOrFail($id);
            $order->update([
                'status_id' => $status_id
            ]);
           
            $updateOrderStatus = new UpdateOrderStatus();
            $updateOrderStatus->updateStatus($order);
           // echo $order->user->available_collect_order_status.' --- '.$order->status_id;die();
          
             
                
           
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
        };

        $notification = array(
        'message' => '<h3>Order Status changed Successfully</h3>',
        'alert-type' => 'success'
        );

        return back()->with($notification);

    }
}
