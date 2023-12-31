<?php

namespace App\Http\Controllers\Admin;

use App\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\City;
use App\Region;
use App\ClientTransactions;
use App\Delegate_client;


class DelegateController extends Controller
{
    public function __construct()
  {
    // $this->middleware('permission:show_delegate', ['only'=>'index', 'show']);
    // $this->middleware('permission:add_delegate', ['only'=>'create', 'store']);
    // $this->middleware('permission:edit_delegate', ['only'=>'edit', 'update']);
    // $this->middleware('permission:delete_delegate', ['only'=>'destroy']);
    // $this->middleware('permission:show_balances', ['only'=>'balances', 'transactions']);
    // $this->middleware('permission:show_follow', ['only'=>'tracking']);
   // $this->middleware('permission:edit_balances', ['only'=>'edit', 'update']);
    // $this->middleware('permission:delete_balances', ['only'=>'transactionDestroy',]);
  }
    public function index(Request $request)
    {
        $type=$request->type;
        $delegates = User::where('user_type', 'delegate')->where('work',$request->type)->orderBy('id', 'desc')->get();

       return view('admin.delegates.index', compact('delegates','type'));
    }
    public function tracking()
    {
        $delegates = User::where('user_type', 'delegate')->orderBy('id', 'desc')->get();

       return view('admin.delegates.tracking', compact('delegates'));
    }
    public function orders($id)
    {
        $delegate = User::findOrFail($id);
        $orders = $delegate->ordersDelegate()->orderBy('id', 'desc')->get();
       return view('admin.delegates.orders', compact('orders'));
    }
    public function create(Request $request)
    {
                $type=$request->type;
                        $clients=User::where('user_type','client')->where('work',$type)->orderBy('id', 'desc')->get();


        $cities   = City::get();
        return view('admin.delegates.add', compact('cities','type','clients'));
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
            'name'                              => 'required',
            'email'                             => 'required|email|unique:users',
                        'phone'                 => 'required|unique:users,phone',

            'password'                          => 'required|min:8|confirmed',
            'city_id'                           => 'required',
        ]);

        $delegateData = $request->all();
        $delegateData['password'] = bcrypt($request->password);

        if ($request->hasFile('avatar')) {
           $avatar = 'avatar/'.$request->user_type.'/'.$request->file('avatar')->hashName();
           $uploaded = $request->file('avatar')->storeAs('public' , $avatar);
           if ($uploaded) {
            $delegateData['avatar'] = $avatar;
           }

        }
        if ($request->hasFile('vehicle_photo')) {
            $vehicle_photo = 'avatar/'.$request->user_type.'/'.$request->file('vehicle_photo')->hashName();
            $uploaded = $request->file('vehicle_photo')->storeAs('public' , $vehicle_photo);
            if ($uploaded) {
             $delegateData['vehicle_photo'] = $vehicle_photo;
            }
 
         } if ($request->hasFile('license_photo')) {
            $license_photo = 'avatar/'.$request->user_type.'/'.$request->file('license_photo')->hashName();
            $uploaded = $request->file('license_photo')->storeAs('public' , $license_photo);
            if ($uploaded) {
             $delegateData['license_photo'] = $license_photo;
            }
 
         } if ($request->hasFile('residence_photo')) {
            $residence_photo = 'avatar/'.$request->user_type.'/'.$request->file('residence_photo')->hashName();
            $uploaded = $request->file('residence_photo')->storeAs('public' , $residence_photo);
            if ($uploaded) {
             $delegateData['residence_photo'] = $residence_photo;
            }
 
         }
        $delegate = User::create($delegateData);
          if($request->client)
        {
           foreach($request->client as $client_id)
           {
                 $Delegate_client=new Delegate_client();
                 $Delegate_client->client_id=$client_id;
                 $Delegate_client->delegate_id=$delegate->id;
                 $Delegate_client->save();
           } 
        }

        if ($delegate) {
            $notification = array(
                'message' => '<h3>Saved Successfully</h3>',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => '<h3>Something wrong Please Try again later</h3>',
                'alert-type' => 'error'
            );
        }

        return redirect()->route('delegates.index',['type'=>$delegate->work])->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $delegate)
    {
        $statuses = Status::get();
        return view('admin.delegates.show', compact('delegate', 'statuses'));
    }

    public function edit(User $delegate)
    {
        $cities   = City::get();
        $region=Region::where('id',$delegate->region_id)->first();
         $Delegate_client=Delegate_client::where('delegate_id',$delegate->id)->pluck('client_id')->toArray();
        $clients=User::where('user_type','client')->where('work',$delegate->work)->orderBy('id', 'desc')->get();
        return view('admin.delegates.edit', compact('delegate', 'cities','region','clients','Delegate_client'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'                              => 'required',
            'email'                             => 'required|unique:users,email,'.$id,
             'phone'                             =>'required|unique:users,phone,' .$id,

            'city_id'                           => 'required',
        ]);
        $delegateData = $request->all();

        $delegate = User::findOrFail($id);
        if($request->password){
            $request->validate([
                'password'                          => 'required|min:8|confirmed',
            ]);
            $delegateData['password'] = bcrypt($request->password);
        }else{
            $delegateData = $request->except(['password']);
        }
        if ($request->hasFile('avatar')) {
            $avatar = 'avatar/'.$delegate->user_type.'/'.$request->file('avatar')->hashName();
            $uploaded = $request->file('avatar')->storeAs('public' , $avatar);
            if ($uploaded) {
             $delegateData['avatar'] = $avatar;
            }

         }
         if ($request->hasFile('vehicle_photo')) {
            $vehicle_photo = 'avatar/'.$request->user_type.'/'.$request->file('vehicle_photo')->hashName();
            $uploaded = $request->file('vehicle_photo')->storeAs('public' , $vehicle_photo);
            if ($uploaded) {
             $delegateData['vehicle_photo'] = $vehicle_photo;
            }
 
         } if ($request->hasFile('license_photo')) {
            $license_photo = 'avatar/'.$request->user_type.'/'.$request->file('license_photo')->hashName();
            $uploaded = $request->file('license_photo')->storeAs('public' , $license_photo);
            if ($uploaded) {
             $delegateData['license_photo'] = $license_photo;
            }
 
         } if ($request->hasFile('residence_photo')) {
            $residence_photo = 'avatar/'.$request->user_type.'/'.$request->file('residence_photo')->hashName();
            $uploaded = $request->file('residence_photo')->storeAs('public' , $residence_photo);
            if ($uploaded) {
             $delegateData['residence_photo'] = $residence_photo;
            }
 
         }
        $delegate->update($delegateData);
         if($request->client)
        {
           foreach($request->client as $client_id)
           {
               $old=Delegate_client::where('delegate_id',$delegate->id)->where('client_id',$client_id)->first();
               if($old==NULL)
               {
                   $Delegate_client=new Delegate_client();
                   $Delegate_client->client_id=$client_id;
                    $Delegate_client->delegate_id=$delegate->id;
                  $Delegate_client->save();
               }

               
           } 
        }
        $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
        );

        return redirect()->route('delegates.index',['type'=>$delegate->work])->with($notification);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function balances(Request $request)
    {
        $delegates = User::orderBy('id', 'desc')->where('work',$request->type)->where('user_type', 'delegate')->paginate(15);
        if(! empty($delegates)){
            foreach($delegates as $client){
                $transactions = ClientTransactions::where('user_id', $client->id);
                $client->count_creditor =  $transactions->sum('creditor');
                    
                $client->count_debtor = $transactions->sum('debtor');
            }
            
        }

        return view('admin.delegates.balances', compact('delegates'));
    }
    public function transactions(Request $request,$id)
    {
         $from               = $request->get('from');
        $to                 = $request->get('to');
        $delegate = User::orderBy('id', 'desc')->where('id', $id)->where('user_type', 'delegate')->first();
        if ($delegate) {
            $transactions = ClientTransactions::orderBy('id', 'desc')->where('user_id', $id);
            if($from != null  && $to != null ){
                $transactions = $transactions->whereDate('created_at', '>=', $from)
                           ->whereDate('created_at', '<=', $to);
            }
            $alltransactions = $transactions->orderBy('id', 'desc')->paginate(50);
            $count_creditor =  $transactions->sum('creditor');
            $count_debtor = $transactions->sum('debtor');
            
            $count_order_creditor =  $transactions->whereNotNull('order_id')->sum('creditor');
            
            $count_order_debtor = $transactions->whereNotNull('order_id')->sum('debtor');
            
            $transactions = $transactions->paginate(50);
            
            return view('admin.delegates.balance-transactions', compact('alltransactions','transactions', 'delegate','from','to','count_debtor','count_creditor','count_order_creditor','count_order_debtor'));
        } else {
            abort(404);
        }
    }

}
