<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Region;
use App\Delegate_client;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
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
    
    public function getclient($id ,Request $request)
    {
        
        $clients=Delegate_client::where('delegate_id',$id)->get();
        $arr=array();

        if(count($clients)==1)
        {
            $name=$clients[0]->user->store_name;
            $id=$clients[0]->user->id;

            $arr[0]="<option value='$id'>  $name </option>";

        }
        else{
            $arr[0]="<option value='0'> أختر العميل </option>";
            foreach($clients as $i=>$model)
        {
            $name=$model->user->store_name;
           
                $arr[$i+1]="<option value='$model->client_id'> $name </option>";

            
        }

        }
          
        
        return \Response::json($arr);
        
    }
}
