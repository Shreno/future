<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\City;
use App\Region;

class RegionsController extends Controller
{
    public function __construct()
  {
    $this->middleware('permission:show_region', ['only'=>'index', 'show']);
    $this->middleware('permission:add_region', ['only'=>'create', 'store']);
    $this->middleware('permission:edit_region', ['only'=>'edit', 'update']);
    $this->middleware('permission:delete_region', ['only'=>'destroy']);
  }
      public function index()
    {
       $regions = Region::with('city')->get();
       return view('admin.cities.indexRegion', compact('regions'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::get();

        return view('admin.cities.addRegion',compact('cities'));
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
            'city_id'   => 'required',

        ]);
        Region::create($request->all());
        $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
        );

        return redirect()->route('cities.index')->with($notification);
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
    public function edit(Region $region)
    {
        $cities = City::get();

        return view('admin.cities.editRegion',compact('cities','region'));
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
            'city_id'   => 'required',

        ]);
        $Region = Region::findOrFail($id);
        $Region->update($request->all());
        $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
        );

        return redirect()->route('regions.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Region::findOrFail($id)->delete();
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
    public function city($id)
    {
       
       $city=City::find($id);
       $regions= Region::where('city_id',$id)->get();
        return view('admin.cities.indexRegion',compact('regions','city'));



    }
    public function getregions($id ,Request $request)
    {
        
        $regions = Region::select('id','title')->where('city_id', '=', $id)->get();
        $arr=array();
              $arr[0]="<option value='0'> أختر الحي </option>";

           

          
        foreach($regions as $i=>$model)
        {
           
                $arr[$i+1]="<option value='$model->id'> $model->title </option>";

            
        }
        return \Response::json($arr);
        
    }
}
