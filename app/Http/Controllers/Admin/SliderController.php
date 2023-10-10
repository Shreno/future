<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Slider;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function __construct()
  {
    $this->middleware('permission:show_slider', ['only'=>'index', 'show']);
    $this->middleware('permission:add_slider', ['only'=>'create', 'store']);
    $this->middleware('permission:edit_slider', ['only'=>'edit', 'update']);
    $this->middleware('permission:delete_slider', ['only'=>'destroy']);
  }
    public function index()
    {
       $sliders = Slider::get();

       return view('admin.website.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.website.slider.add'); 
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
            'image'      => 'required|mimes:jpeg,jpg,png',
        ]);
        
        $sliderData = $request->all();
        if ($request->hasFile('image')) {
            $image = 'website/slider/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public' , $image);
            if ($uploaded) {
             $sliderData['image'] = $image;
            }
        }
        $slider = Slider::create($sliderData);

        if ($slider) {
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
        
        return redirect()->route('sliders.index')->with($notification);
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
    public function edit(Slider $slider)
    {
        
        return view('admin.website.slider.edit', compact('slider'));
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
        $sliderData = $request->all();
        $slider = Slider::findOrFail($id);
        if ($request->hasFile('image')) {
            $request->validate([
                'image'      => 'mimes:jpeg,jpg,png',
            ]);
            Storage::delete('public/'.$slider->image);
            $image = 'website/slider/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public' , $image);
            if ($uploaded) {
             $sliderData['image'] = $image;
            }
        }
        if ($slider->update($sliderData)) {
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
        
        return redirect()->route('sliders.index')->with($notification);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $delete =  Storage::delete('public/'.$slider->image);
        if ($delete) {
            $slider->delete();
        }
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
}
