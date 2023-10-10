<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RequestJoin;

class RequestJoinController extends Controller
{
    public function __construct()
  {
    $this->middleware('permission:show_requestJoin', ['only'=>'index', 'show']);
    $this->middleware('permission:delete_requestJoin', ['only'=>'destroy']);
  }
   
    public function index()
    {
        $requestJoin = RequestJoin::orderBy('id','DESC')->get();
        return view('admin.requests.index', compact('requestJoin'));
    }

    

    public function show(RequestJoin $requestJoin)
    {
        $is_readed = [
            'is_readed' => 1,
        ];
        $requestJoin->update($is_readed);
        return view('admin.requests.show', compact('requestJoin')); 
    }

    
    public function destroy($id)
    {
        $requestJoin = RequestJoin::findOrFail($id);
        if ($requestJoin) {
            $requestJoin->delete();
        }
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success'
        );

        return redirect()->route('request-joins.index')->with($notification);
    }
}
