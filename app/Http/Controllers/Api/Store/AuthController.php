<?php

namespace App\Http\Controllers\Api\Store;

use App\Events\SendLocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetEmail;

class AuthController extends Controller
{
    public function __construct()
  {
    $this->middleware('auth:api')->except('login', 'forgetPassword', 'resetPassword');
    // Unique Token
    $this->apiToken = uniqid(base64_encode(str_random(60)));
  }
    public function login(Request $request)
  {
    // Validations
    $rules = [
      'phone'=>'required',
      'password'=>'required|min:6'
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      // Validation failed
      return response()->json([
        'message' => $validator->messages(),
      ]);
    } else {
        $credentials = $request->only('phone', 'password');
        if (Auth::attempt($credentials)) {
            $apiToken = ['api_token' => $this->apiToken];
            $user = User::where('phone',$request->phone)->first();
            if ($user->user_type == 'client') {
              User::where('phone',$request->phone)->update($apiToken);

              if($user->work==1)
              {
               $work="طرود";
              }else{
              $work= 'طلبات';
              }
            return response()->json([
              'success'      => 1,
              'user' => [
                'id'           => $user->id,
                'name'         => $user->name,
                'email'        => $user->email,
                'phone'        => $user->phone,
                'avatar'       => asset('storage/'.$user->avatar),
                'api_token'    => $this->apiToken,
                'work_type'         => $work,
            ],
              ]);
            }else {
              return response()->json([
                'success'      => 0,
                'message' => 'Invalid User Name Or Password',
              ]);
            }

        } else {
            return response()->json([
                'message' => 'Invalid User Name Or Password',
              ]);
        }

    }
  }
  public function logout(Request $request)
  {
      $apiToken = ['api_token' => null];
        $logout = User::where('id',$request->user()->id)->update($apiToken);

          return response()->json([
            'message' => 'User Logged Out',
          ]);

  }

  public function forgetPassword(Request $request)
  {
    $rules = [
      'email'     => 'required|email'
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      // Validation failed
      return response()->json([
        'success'      => 0,
        'message' => $validator->messages(),
      ]);
    }
    $email = $request->email;
    $check = User::where('email', $email)->first();
    if(!$check){
      return response()->json([
        'message' => 'This email not exist',
      ], 404);
    }
    $code    = rand(1000,9999);
    $createAt = time();
    $expiredDate = date('Y-m-d H:i:s', strtotime('+1 day', $createAt));
    // return $expiredDate;
    $updatedData = [
        'reset_code'      => $code,
        'code_expired_at' => $expiredDate
    ];
    // return $check;
    $update = User::where('email',$email)->update($updatedData);
    if ($update) {
      Mail::to($email)->send(new ResetEmail($code));
      return response()->json([
        'success'      => 1,
        'message' => 'Activation Code Send to your Email',
      ], 200);

    }
    return response()->json([
      'success'      => 0,
      'message' => 'somthing wrong please try againe later',
    ], 500);

  }

  public function resetPassword(Request $request)
  {
    $rules = [
      'code'     => 'required|numeric|min:4',
      'password' => 'required|min:6'
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      // Validation failed
      return response()->json([
        'success'      => 0,
        'message' => $validator->messages(),
      ]);
    }
    $code = $request->code;
    $user = User::where('reset_code', $code)->first();
    if (! $user) {
      return response()->json([
        'success'      => 0,
        'message' => 'This code is not valid',
      ], 500);
    }
    $now = now();
    // return $now;
    if ($user->code_expired_at < $now) {
      return response()->json([
        'success'      => 0,
        'message' => 'This code is expired',
      ], 500);
    }

    $data = [
      'password'        => bcrypt($request->password),
      'reset_code'      => null,
      'code_expired_at' => null
    ];
    $update = User::where('email',$user->email)->update($data);

    if ($update) {
      return response()->json([
        'success'      => 1,
        'message' => 'password changed successfully',
      ], 200);
    }
    return response()->json([
      'success'      => 0,
      'message' => 'somthing wrong please try againe later',
    ], 500);
  }

  public function location(Request $request)
  {
    $user = Auth::user();
    $rules = [
      'lat'     => 'required|numeric',
      'long'    => 'required|numeric'
    ];
    $validator = Validator::make($request->all(), $rules);


    if ($validator->fails()) {
      // Validation failed
      return response()->json([
        'message' => $validator->messages(),
      ]);
    }
    $lat = $request->lat;
    $long = $request->long;
    $id   = $user->id;
    $name   = $user->name;
    $avater   = asset('storage/'.$user->avatar);
    $location = [
            "lat"=>$lat,
            "long"=>$long,
            "id"=>$id,
            // "name"=>$name,
            // "avatar"=>$avater
  ];
    event(new SendLocation($location));
    return response()->json(['success'=>1, 'data'=>$location]);
  }
  public function analytics(Request $request)
  {
    $user = Auth::user();

      $ordersToday = $user->orders()->PickupToday()->count();
      $balance = DB::table('client_transactions')->select(array(DB::raw('SUM(debtor - creditor) as total')))
          ->where('user_id', $user->id)
          ->where('deleted_at', null)
          ->first();
      $balance = $balance->total;
      $allMyOrders = $user->orders()->count();
      return response()->json([
          'success'   => 1,
          'Statistics' => [
              'OrdersShipToday' => $ordersToday,
              'AllMyOrders'     => $allMyOrders,
              'BalanceAccount'  => $balance,
          ]
      ]);
  }
}
