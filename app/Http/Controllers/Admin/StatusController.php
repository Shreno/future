<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Status;

class StatusController extends Controller
{

    //delegate_appear
    public function __construct()
    {
      $this->middleware('permission:show_status', ['only'=>'index', 'show']);
      $this->middleware('permission:add_status', ['only'=>'create', 'store']);
      $this->middleware('permission:edit_status', ['only'=>'edit', 'update']);
      $this->middleware('permission:delete_status', ['only'=>'destroy']);
    }
    public function index()
    {
        $statuses = Status::get();

        return view('admin.statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.statuses.add');
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
            'title'   => 'required',
        ]);
        Status::create($request->all());
        $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
        );

        return redirect()->route('statuses.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        return view('admin.statuses.edit', compact('status'));
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
            'title'   => 'required',
        ]);
        $status = Status::findOrFail($id);
        $status->update($request->all());
        $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
        );

        return redirect()->route('statuses.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Status::findOrFail($id)->delete();
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    function change_delegate_appear(Request $request){
        $id = $request->id;
        $data = Status::findOrFail($id);
        if ($data != null) {
            if( $data->delegate_appear == 0)
            {
                $data->delegate_appear = 1;
            }else{
                $data->delegate_appear =0;
            }
            $data->save();

            return $data->delegate_appear;
        }else{
            return 'error';
        }

    }
    
    function change_client_appear(Request $request){
        $id = $request->id;
        $data = Status::findOrFail($id);
        if ($data != null) {
            if( $data->client_appear == 0)
            {
                $data->client_appear = 1;
            }else{
                $data->client_appear =0;
            }
            $data->save();

            return $data->client_appear;
        }else{
            return 'error';
        }

    }
        function change_restaurant_appear(Request $request){
        $id = $request->id;
        $data = Status::findOrFail($id);
        if ($data != null) {
            if( $data->restaurant_appear == 0)
            {
                $data->restaurant_appear = 1;
            }else{
                $data->restaurant_appear =0;
            }
            $data->save();

            return $data->restaurant_appear;
        }else{
            return 'error';
        }

    }    function change_shop_appear(Request $request){
        $id = $request->id;
        $data = Status::findOrFail($id);
        if ($data != null) {
            if( $data->shop_appear == 0)
            {
                $data->shop_appear = 1;
            }else{
                $data->shop_appear =0;
            }
            $data->save();

            return $data->shop_appear;
        }else{
            return 'error';
        }

    }
}
