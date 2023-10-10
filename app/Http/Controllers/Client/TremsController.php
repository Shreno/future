<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TremsController extends Controller
{
   public function index()
   {
       return view('client.terms.show');
   }
   public function agree()
   {
       $user = Auth()->user();
       $data = ['read_terms' => 1];
       $user->update($data);
       $notification = array(
        'message' => '<h3>Thank you for Agree </h3>',
        'alert-type' => 'info'
    );
    return redirect()->route('client.dashboard')->with($notification);
   }
}
