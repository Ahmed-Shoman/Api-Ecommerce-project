<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);

        return response()->json($products, 200);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string',
            'price'       => 'required|numeric',
            'category_id' => 'required|integer',
            'brand_id'    => 'required|integer',
            'discount'    => 'required|numeric',
            'amount'      => 'required|integer',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $product = new Product();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $path = public_path('assets/uploads/products');

                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true);
                }

                $file->move($path, $filename);
                $product->image = $filename;
            }

            $product->name        = $request->name;
            $product->price       = $request->price;
            $product->brand_id    = $request->brand_id;
            $product->category_id = $request->category_id;
            $product->discount    = $request->discount;
            $product->amount      = $request->amount;

            $product->save();

            return response()->json([
                'message' => 'Product created successfully',
                'data'    => $product
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update($id, Request $request)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string',
            'price'       => 'required|numeric',
            'category_id' => 'required|integer',
            'brand_id'    => 'required|integer',
            'discount'    => 'required|numeric',
            'amount'      => 'required|integer',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product->name        = $request->name;
        $product->price       = $request->price;
        $product->brand_id    = $request->brand_id;
        $product->category_id = $request->category_id;
        $product->discount    = $request->discount;
        $product->amount      = $request->amount;

        if ($request->hasFile('image')) {

            $oldPath = public_path('assets/uploads/products/' . $product->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads/products'), $filename);

            $product->image = $filename;
        }

        $product->save();

        return response()->json([
            'message' => 'Product updated successfully',
            'data'    => $product
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $imagePath = public_path('assets/uploads/products/' . $product->image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
