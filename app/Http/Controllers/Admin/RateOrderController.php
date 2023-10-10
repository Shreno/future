<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RateOrder;

class RateOrderController extends Controller
{
    public function __construct()
  {
    $this->middleware('permission:show_rate', ['only'=>'index', 'show']);
    $this->middleware('permission:add_rate', ['only'=>'create', 'store']);
    $this->middleware('permission:edit_rate', ['only'=>'edit', 'update']);
    $this->middleware('permission:delete_rate', ['only'=>'destroy']);
  }
    public function index()
    {
       $rate_orders = RateOrder::get();
       return view('admin.rate_orders.index', compact('rate_orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.rate_orders.add');
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
        RateOrder::create($request->all());
        $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
        );

        return redirect()->route('rate_orders.index')->with($notification);
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
    public function edit(RateOrder $rate_order)
    {
        return view('admin.rate_orders.edit', compact('rate_order'));
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
        $rate_order = RateOrder::findOrFail($id);
        $rate_order->update($request->all());
        $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
        );

        return redirect()->route('rate_orders.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RateOrder::findOrFail($id)->delete();
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
}
