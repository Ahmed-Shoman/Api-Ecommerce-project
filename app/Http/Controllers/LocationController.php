<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function store()
    {
        $request->validated([
            'street'=>'required',
            'building'=>'required',
            'area'=>'required',
        ]);
        Location::create([
            'street'=>$request->street,
            'building'=>$request->building,
            'area'=>$request->area,
            'user_id'=>Auth::id(),
        ]);
        return response()->json('location added' , 201);
    }

    public function update(Request $request,$id){
        $request->validated([
            'street'=>'required',
            'building'=>'required',
            'area'=>'required',
        ]);

        if($location){
        $Location=Location::find($id);
        $location->street=$request->street;
        $location->building=$request->building;
        $location->area=$request->area;
        $location->save();
        return response()->json('location updated');

        }
        else return response()->json('location not founded');


    }

    public function destroy()
    {
        $location = Location::find($id);
        if($location){
            $location->delete();
            return response()->json('location deleted');
        }
        else return response()->json('location not found');
    }

}

