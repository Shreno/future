<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services;
use App\IconClass;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function __construct()
  {
    $this->middleware('permission:show_service', ['only'=>'index', 'show']);
    $this->middleware('permission:add_service', ['only'=>'create', 'store']);
    $this->middleware('permission:edit_service', ['only'=>'edit', 'update']);
    $this->middleware('permission:delete_service', ['only'=>'destroy']);
  }
    public function index()
    {
        $services = Services::get();

        return view('admin.website.service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $icons = IconClass::get();
        return view('admin.website.service.add', compact('icons'));
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
            'title_en'      => 'required',
            'title_ar'      => 'required',
            'image'         => 'nullable|mimes:jpeg,jpg,png',
        ]);

        $serviceData = $request->all();
        if ($request->hasFile('image')) {
            $image = 'website/services/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public' , $image);
            if ($uploaded) {
                $serviceData['icon_class'] = $image;
            }
        }
        $service = Services::create($serviceData);

        if ($service) {
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

        return redirect()->route('services.index')->with($notification);
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
    public function edit(Services $service)
    {
        $icons = IconClass::get();
        return view('admin.website.service.edit', compact('service', 'icons'));
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
        $service = Services::findOrFail($id);

        $serviceData = $request->all();

        if ($request->hasFile('image')) {
            $request->validate([
                'image'      => 'mimes:jpeg,jpg,png',
            ]);
            Storage::delete('public/'.$service->icon_class);
            $image = 'website/services/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public' , $image);
            if ($uploaded) {
                $serviceData['icon_class'] = $image;
            }
        }

        if ($service->update($serviceData)) {
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

        return redirect()->route('services.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Services::findOrFail($id);
        if ($service) {
            Storage::delete('public/'.$service->icon_class);
            $service->delete();
        }
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
}
