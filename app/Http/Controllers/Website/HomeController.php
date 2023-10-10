<?php

namespace App\Http\Controllers\Website;

use App\Mail\RequestEmail;
use App\Mail\SendEmail;

use App\Mail\ContactEmail;
use App\Order;
use ArPHP\I18N\Arabic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Slider;
use App\WhatWeDo;
use App\Services;
use App\RateOrder;
use App\Feedback;
use App\Post;
use App\Branch;
use App\Contact;
use App\RequestJoin;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class HomeController extends Controller
{
   public function index()
   {
        return redirect()->route('login');
      $sliders = Slider::get();
      $whatWeDo = WhatWeDo::get();
      $services = Services::get();
      $latestPosts = Post::Post()
      ->Published()
      ->latest()
      ->limit(3)
      ->get();

      $reviews = RateOrder::where('is_publish',1)->orderBy('created_at','DESC')->take(8)->get();
    return view('website.index', compact('sliders', 'whatWeDo', 'services', 'latestPosts','reviews'));
   }
   public function about()
   {
    $branches = Branch::get();
    return view('website.about', compact('branches'));
   }
   public function contact()
   {
    return view('website.contact');
   }
   public function contactSubmit(Request $request)
   {
      $request->validate([
         'name'   => 'required|max:100',
         'email'   => 'required|email',
         'subject'   => 'required|max:100',
         'message'   => 'required|max:200',
         'g-recaptcha-response'  => 'required|captcha'
     ]);
      $requestJoin = Contact::create($request->all());

      //send mail
      Mail::to('order@logexpro.com')->send(new ContactEmail($requestJoin ));
      $notification = array(
          'message' => __('website.send_success'),
          'alert-type' => 'success'
      );

      return back()->with($notification);
   }

   public function feedback()
   {
    return view('website.feedback');
   }
   public function feedbackSubmit(Request $request)
   {
      $request->validate([
         'sender_name'   => 'required|max:100',
         'sender_mobile'   => 'required',
         'sender_address'   => 'required|max:200',
         'receiver_name'   => 'required|max:100',
         'receiver_mobile'   => 'required',
         'receiver_address'   => 'required|max:200',
         'content'   => 'required|max:200',
         'g-recaptcha-response'  => 'required|captcha'
     ]);
      $requestJoin = Feedback::create($request->all());

      //send mail
      Mail::to('order@logexpro.com')->send(new SendEmail($requestJoin ));
      $notification = array(
          'message' => __('website.send_success'),
          'alert-type' => 'success'
      );

      return back()->with($notification);
   }
   public function requestJoin()
   {
    return view('website.request-join');
   }
   public function requestJoinSubmit(Request $request)
   {
      $request->validate([
         'name'    => 'required|max:100',
         'email'   => 'required|email',
         'phone'   => 'required|numeric',
         'address' => 'required|max:100',
         'store'   => 'required|max:100',
         'g-recaptcha-response'  => 'required|captcha'
     ]);
     $requestJoin =  RequestJoin::create($request->all());
      if ($requestJoin){
          Mail::to($requestJoin->email)->send(new RequestEmail($requestJoin));
          $notification = array(
              'message' => __('website.send_success'),
              'alert-type' => 'success'
          );
      }

      return back()->with($notification);
   }


   public function tracking(Request $request)
   {

       if ($request->tracking_id) {
           $order = Order::where('tracking_id', $request->tracking_id)->first();
           if ($order) {
                $orderDetails = $order;
               $orderHistory = $order->history()->get();
               return view('website.track', compact('orderHistory', 'orderDetails'));
           }else{
               $track_num = $request->tracking_id;
               return view('website.track', compact('track_num'));
           }
       }else{
           abort(404);
       }


   }

   //RateOrder

   public function rate_order($order_no,$mobile)
   {
        $orderCheck     = Order::where('order_id',$order_no)->where('receved_phone',$mobile)->first();
        if(! empty($orderCheck)){
            $name = $orderCheck->receved_name;
            return view('website.rate', compact('order_no','mobile','name'));
        }else{
            $notification = array(
              'message' => __('website.this_order_not_found'),
              'alert-type' => 'success'
            );

            return back()->with($notification);
        }

   }
   public function list_rate_order()
   {
        $rates    = RateOrder::orderBy('created_at','DESC')->where('is_publish',1)->paginate(20);

        return view('website.list_rate', compact('rates'));

   }

   public function post_rate_order(Request $request,$order_no,$mobile)
   {
        $orderCheck     = Order::where('order_id',$order_no)->where('receved_phone',$mobile)->first();

        if(! empty($orderCheck)){
            $name                   = $orderCheck->receved_name;
            $order_id               = $orderCheck->id;

            $rate_order             = new RateOrder();
            $rate_order->name       = $name;
            $rate_order->order_no   = $order_no;
            $rate_order->order_id   = $order_id;
            $rate_order->mobile     = $mobile;
            $rate_order->rate       = $request->rate;
            $rate_order->review     = $request->review;
            $rate_order->is_publish    = 1;
            $rate_order->save();
            $notification = array(
              'message' => __('website.send_success'),
              'alert-type' => 'success'
            );

            return back()->with($notification);

        }else{
            $notification = array(
              'message' => __('website.this_order_not_found'),
              'alert-type' => 'danger'
            );

            return back()->with($notification);
        }
   }

   public function printOrder(Request $request)
   {
       $order = Order::where('order_id',$request->order_id)->first();
       if(is_null($order)){
           abort(404);
       }
     //  return view('website.show-as-pdf',compact('order'));

      $pdf = PDF::loadView('website.show-as-pdf', ['order' => $order]);
      
       if(! file_exists(public_path('orders/'.$order->order_id.'.pdf'))){
           $pdf->save(public_path('orders/'.$order->order_id.'.pdf'));
       }

       return $pdf->stream('testOrder.pdf');
   }
}
