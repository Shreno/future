<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppSetting;

class SettingController extends Controller
{
    public function __construct()
  {
    $this->middleware('permission:edit_adminSetting', ['only'=>'edit', 'update']);
  }
    
    public function edit()
    {
      $settings = AppSetting::where('id', 1)->first();

       return view('admin.settings.edit', compact('settings')); 
    }

   
    public function update(Request $request)
    {
        $settings     = AppSetting::where('id', 1)->first();
        $settingsData = $request->all();
        
        
        
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
