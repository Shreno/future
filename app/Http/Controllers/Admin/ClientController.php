<?php

namespace App\Http\Controllers\Admin;

use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Status;
use App\Models\City;
use App\Models\Region;
use App\Models\Address;
use App\ClientTransactions;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    public function __construct()
  {
    //   $this->middleware('permission:show_client', ['only'=>'index', 'show', 'api']);
    // $this->middleware('permission:show_resturant', ['only'=>'index', 'show', 'api']);

    // $this->middleware('permission:add_client', ['only'=>'create', 'store']);
    // $this->middleware('permission:add_resturant', ['only'=>'create', 'store']);

    // $this->middleware('permission:edit_client', ['only'=>'edit', 'update', 'apiStore']);
    // $this->middleware('permission:edit_resturant', ['only'=>'edit', 'update', 'apiStore']);

    // $this->middleware('permission:delete_client', ['only'=>'destroy', 'apiDestroy']);
    // $this->middleware('permission:delete_resturant', ['only'=>'destroy', 'apiDestroy']);

    // $this->middleware('permission:show_balances', ['only'=>'balances', 'transactions']);
    // $this->middleware('permission:show_balance_res', ['only'=>'balances', 'transactions']);
    // $this->middleware('permission:add_balances', ['only'=>'transactionStore']);

    // $this->middleware('permission:add_balance_res', ['only'=>'transactionStore']);
    // $this->middleware('permission:delete_balances', ['only'=>'transactionDestroy',]);
    // $this->middleware('permission:delete_balance_res', ['only'=>'transactionDestroy',]);

    // Unique Token
    $this->apiToken = uniqid(base64_encode(str_random(60)));
  }
    public function index(Request $request)
    {
        $work=$request->type;
        $clients = User::where('user_type', 'client')->where('work',$request->type)->orderBy('id', 'desc')->get();

        return view('admin.clients.index', compact('clients','work'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       $work=$request->type;

        $statuses = Status::get();
        $cities   = City::get();
        return view('admin.clients.add', compact('statuses', 'cities','work'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                              => 'required',
            'email'                             => 'required|email|unique:users',
                        'phone'                 => 'required|unique:users,phone',
            'password'                          => 'required|min:8|confirmed',
            'store_name'                        => 'required',
            'cost_inside_city'                  => 'required|numeric',
            'city_id'                           => 'required',
           'tax_Number'                       =>'required|digits:15|numeric'

        ]);

        $clientData = $request->all();
        $clientData['password'] = bcrypt($request->password);
            if ($request->hasFile('Tax_certificate')) {
            $Tax_certificate = 'avatar/client/'.$request->file('Tax_certificate')->hashName();
            $uploaded = $request->file('Tax_certificate')->storeAs('public' , $Tax_certificate);
            if ($uploaded) {
             $clientData['Tax_certificate'] = $Tax_certificate;
            }
 
         }

         if ($request->hasFile('commercial_register')) {
            $commercial_register = 'avatar/client/'.$request->file('commercial_register')->hashName();
            $uploaded = $request->file('commercial_register')->storeAs('public' , $commercial_register);
            if ($uploaded) {
             $clientData['commercial_register'] = $commercial_register;
            }
 
         }
        $client = User::create($clientData);

        if ($client) {
            // Mail::to($client->email)->send(new WelcomeEmail($client->name));
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

        return redirect()->route('clients.index',['type'=>$client->work])->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $client)
    {
       $addresses = Address::where('user_id', $client->id)->get();
        $transactions = ClientTransactions::where('user_id', $client->id);

        $alltransactions = $transactions->orderBy('id', 'desc')->paginate(50);
        $count_creditor =  $transactions->sum('creditor');
        $count_debtor = $transactions->sum('debtor');
        
        $count_order_creditor =  $transactions->whereNotNull('order_id')->sum('creditor');
        
        $count_order_debtor = $transactions->whereNotNull('order_id')->sum('debtor');
        return view('admin.clients.show', compact('client', 'addresses','count_creditor','count_debtor','count_order_creditor','count_order_debtor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $client)
    {
        $statuses = Status::get();
        $cities   = City::get();
        return view('admin.clients.edit', compact('client', 'statuses', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name'                              => 'required',
            'email'                             => 'required|unique:users,email,' . $id,
           'phone'                             =>'required|unique:users,phone,' .$id,

            'store_name'                        => 'required',
            'cost_inside_city'                  => 'required|numeric',
            'city_id'                           => 'required',
             'tax_Number'                       =>'required'
        ]);

        $clientData = $request->all();
        $client = User::findOrFail($id);
        if ($request->password) {
            $request->validate([
                'password'                          => 'required|min:8|confirmed',
            ]);
            $clientData['password'] = bcrypt($request->password);
                        if ($request->hasFile('Tax_certificate')) {
            $Tax_certificate = 'avatar/client/'.$request->file('Tax_certificate')->hashName();
            $uploaded = $request->file('Tax_certificate')->storeAs('public' , $Tax_certificate);
            if ($uploaded) {
             $clientData['Tax_certificate'] = $Tax_certificate;
            }
 
         }

         if ($request->hasFile('commercial_register')) {
            $commercial_register = 'avatar/client/'.$request->file('commercial_register')->hashName();
            $uploaded = $request->file('commercial_register')->storeAs('public' , $commercial_register);
            if ($uploaded) {
             $clientData['commercial_register'] = $commercial_register;
            }
 
         }
            $client->update($clientData);
        } else {

                        if ($request->hasFile('Tax_certificate')) {
            $Tax_certificate = 'avatar/client/'.$request->file('Tax_certificate')->hashName();
            $uploaded = $request->file('Tax_certificate')->storeAs('public' , $Tax_certificate);
            if ($uploaded) {
             $clientData['Tax_certificate'] = $Tax_certificate;
            }
 
         }

         if ($request->hasFile('commercial_register')) {
            $commercial_register = 'avatar/client/'.$request->file('commercial_register')->hashName();
            $uploaded = $request->file('commercial_register')->storeAs('public' , $commercial_register);
            if ($uploaded) {
             $clientData['commercial_register'] = $commercial_register;
            }
 
         }
            $client->update($request->except(['password']));
        }
        $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
        );

        return redirect()->route('clients.index', ['type' => $client->work])->with($notification);
    }


    public function balances(Request $request)
    {
                 $type=$request->type;

        $clients = User::orderBy('id', 'desc')->where('work',$request->type)->where('user_type', 'client')->paginate(15);
        
        $select_clients = User::orderBy('name', 'asc')->where('work',$request->type)->where('user_type', 'client')->get();
        if(! empty($clients)){
            foreach($clients as $client){
                $transactions = ClientTransactions::where('user_id', $client->id);
                $client->count_creditor =  $transactions->sum('creditor');
                    
                $client->count_debtor = $transactions->sum('debtor');
            }
            
        }

        return view('admin.clients.balances', compact('clients','select_clients','type'));
    }
    public function transactions(Request $request,$id)
    {
        $from               = $request->get('from');
        $to                 = $request->get('to');
        $client = User::orderBy('id', 'desc')->where('id', $id)->where('user_type', 'client')->first();
        if ($client) {
            $transactions = ClientTransactions::where('user_id', $id);
            if($from != null  && $to != null ){
                $transactions = $transactions->whereDate('created_at', '>=', $from)
                           ->whereDate('created_at', '<=', $to);
            }
            $alltransactions = $transactions->orderBy('id', 'desc')->paginate(50);
            $count_creditor =  $transactions->sum('creditor');
            $count_debtor = $transactions->sum('debtor');
            
            $count_order_creditor =  $transactions->whereNotNull('order_id')->sum('creditor');
            
            $count_order_debtor = $transactions->whereNotNull('order_id')->sum('debtor');

            return view('admin.clients.balance-transactions', compact('alltransactions', 'client','from','to','count_debtor','count_creditor','count_order_debtor','count_order_creditor'));
        } else {
            abort(404);
        }
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
    public function transactionStore(Request $request)
    {
        $data = $request->all();
        $amount =0.00 ;
        if($request->debtor){
            $amount = $request->debtor;
        }elseif($request->amount){
            $amount = $request->amount;
        }
        if ($request->type == 'debtor') {
              $data['debtor'] = $amount;
              $data['creditor'] = 0.00;
              ClientTransactions::create($data);
              
       } elseif ($request->type == 'creditor')  {
           
            $data['creditor'] = $amount;
            $data['debtor'] = 0.00;
            ClientTransactions::create($data);
       }

        
        $notification = array(
            'message' => '<h3>Save Successfully</h3>',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
    public function transactionDestroy($id)
    {
        ClientTransactions::findOrFail($id)->delete();
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function api()
    {
        $clients = User::where('user_type', 'client')
        ->where('api_token', '=', null)
        ->get();
        $apiList = User::where('user_type', 'client')
        ->where('api_token', '!=', null)
        ->paginate(15);

        return view('admin.clients.api', compact('clients', 'apiList'));
    }

    public function apiStore(Request $request)
    {
        $id = $request->user_id;
        $client = User::findOrFail($id);
        if ($client) {
            User::where('id',$id)->update([
                'api_token' => $this->apiToken,
                'domain'    => $request->domain
            ]);
            $notification = array(
                'message' => '<h3>Save Successfully</h3>',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => '<h3>Client Not Exist</h3>',
                'alert-type' => 'error'
            );
        }
        return back()->with($notification);

    }

    public function apiDestroy($id)
    {
        User::where('id',$id)->update([
            'api_token' => null,
            'domain' => null
        ]);
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'info'
        );
        return back()->with($notification);
    }
    public function addresses($id)
    {
         $addresses = Address::where('user_id',$id)->get();

        return view('admin.clients.addresses.index', compact('addresses','id'));
        
    }
    // 
       public function address_create($id)
    {
        $cities = City::get();
        return view('admin.clients.addresses..add', compact('cities','id'));
    }
        public function address_store(Request $request)
    {
        $request->validate([
            'city_id'                           => 'required|numeric',
            'region_id'                           => 'numeric',

            'address'                           => 'required|min:10|max:100',
            'description'                       => 'required|min:10|max:200',
            'phone'                             => 'numeric',
        ]);

        $user = User::where('id',$request->id)->first();

        $user->addresses()->create($request->all());
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success'
        );
        return redirect()->route('clients.index', ['type' => $user->work])->with($notification);
    }
   
        
        public function address_edit($id)
    {
        $address = Address::findOrFail($id);
        $cities = City::get();
        $region=Region::where('id',$address->region_id)->first();
        return view('admin.clients.addresses.edit', compact('cities', 'address','region'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Address_update(Request $request, $id)
    {
        $request->validate([
            'city_id'          => 'required|numeric',
                        'region_id'                           => 'numeric',

            'address'          => 'required|min:10|max:100',
            'description'      => 'required|min:10|max:200',
            'phone'            => 'numeric',
        ]);
        
        $address = Address::findOrFail($id);
        $address->update($request->all());
        $user = User::where('id',$address->user_id)->first();

        $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
        );

        return redirect()->route('clients.index', ['type' => $user->work])->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function address_delete($id)
    {
        Address::findOrFail($id)->delete();
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
}
