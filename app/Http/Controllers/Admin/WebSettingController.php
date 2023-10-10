<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WebSetting;
use Illuminate\Support\Facades\Storage;

class WebSettingController extends Controller
{
    public function __construct()
    {
      $this->middleware('permission:edit_websiteSetting', ['only'=>'edit', 'update']);
    }
    
    public function edit()
    {
       $settings = WebSetting::where('id', 1)->first();

       return view('admin.website.settings.edit', compact('settings')); 
    }

    
    public function update(Request $request)
    {
        $settings     = WebSetting::where('id', 1)->first();
        $settingsData = $request->all();
        if ($request->hasFile('logo')) {
            $request->validate([
                'logo'      => 'mimes:jpeg,jpg,png',
            ]);
            Storage::delete('public/'.$settings->logo);
            $logo = 'website/logo/'.$request->file('logo')->hashName();
            $uploaded = $request->file('logo')->storeAs('public' , $logo);
            if ($uploaded) {
             $settingsData['logo'] = $logo;
            }
        }
        if ($request->hasFile('image')) {
            $request->validate([
                'image'      => 'mimes:jpeg,jpg,png',
            ]);
            Storage::delete('public/'.$settings->image);
            $image = 'website/about/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public' , $image);
            if ($uploaded) {
             $settingsData['image'] = $image;
            }
        }
        
        if ($settings->update($settingsData)) {
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


        return back()->with($notification);
    }

    
}
