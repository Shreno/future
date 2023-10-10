<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CitiesResource;
use App\Http\Resources\RegionsResource;

use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{

    public function cities()
    {
      
                $cities = CitiesResource::collection(City::get());
                if (count($cities) == 0) 
                {
                    return response()->json(["message" => "No Orders found"]);
                }
                else
                {
                return response()->json($cities);
                } 

     
    }
    public function regions($city_id)
    {
        if($city_id)
        {
                $regions = RegionsResource::collection(Region::where('city_id',$city_id)->get());

                if (count($regions) == 0) 
                {
                    return response()->json(["message" => "No regions found"]);
                }
                else
                {
                return response()->json($regions);
                } 
        }
        else
        {
            return response()->json([
                'success'   => 0,
                'message' => 'you shoud enter the city id ',
            ], 503);
        }
        
    }


}
