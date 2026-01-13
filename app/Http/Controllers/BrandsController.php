<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    public function index()
    {
        $brands=Brand::paginate(10);
        return response()->json($brands , 200);
    }

    public function show ($id)
    {
        $brands = Brand::find($id);
        if ($brands)
            {
                return response()->json($brands,200);
            }else return response()->json('brand not found');
    }

     public function store(Request $request)
     {
        try
        {
            $validated = $request->validate([
                'name'=>'required|unique:brands,name'
            ]);
            $brands = new Brand();
            $brands->name = $request->name;
            $brands->save();
            return response()->json('brand added' ,201);
        }catch(Exception $e)
        {
            return response()->json($e , 500);
        }
     }

     public function update_brand($id , Request $request)
     {
        try
        {
            $validated = $request->request([
                'name'=>'required',
            ]);
            $brands = Brand::where('id' , $id )->update(['name'=>request()->name]);
            return response()->json('brand updated' , 200);
        }catch(Exception $e)
        {
            return response()->json($e , 500 );
        }
     }

     public function brand_delete($id)
     {
        $brand = Brand::find($id);
        if($brand)
            {
                $brand ->delete();
                return response()->json('brand deleted');
            }
            else return response()->json('brand not found');
     }



}