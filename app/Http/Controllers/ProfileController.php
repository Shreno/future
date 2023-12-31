<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function edit()
    {
        $cities   = City::get();
        $user = Auth()->user();

        return view('profile', compact('user', 'cities'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'                              => 'required',
            'email'                             => 'required|unique:users,email,'.$id,
            'phone'                             => 'required|unique:users,phone,'.$id,

            'city_id'                           => 'required',
        ]);
        $userData = $request->all();
        
        $user = User::findOrFail($id);
        if($request->password){
            $request->validate([
                'password'                          => 'required|min:8|confirmed',
            ]);
            $userData['password'] = bcrypt($request->password);
        }else{
            $userData = $request->except(['password']);
        }
        if ($request->hasFile('avatar')) {
            $avatar = 'avatar/'.$user->user_type.'/'.$request->file('avatar')->hashName();
            $uploaded = $request->file('avatar')->storeAs('public' , $avatar);
            if ($uploaded) {
             $userData['avatar'] = $avatar;
            }
            
         }
        $user->update($userData);
        $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
}
