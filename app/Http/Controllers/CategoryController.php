<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $Categories = Category::paginate(10);
        return response()->json($Categories, 200);
    }

    public function show($id)
    {
        $categories = Category::find($id);

        if ($categories) {
            return response()->json($categories, 200);
        } else {
            return response()->json('category not found', 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'  => 'required|unique:categories,name',
                'image' => 'required'
            ]);

            $categories = new Category();
            $categories->name = $request->name;
            $categories->image = $request->image;
            $categories->save();

            return response()->json('category added', 201);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function update_category(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name'  => 'required',
                'image' => 'required',
            ]);

            Category::where('id', $id)->update([
                'name'  => $request->name,
                'image' => $request->image
            ]);

            return response()->json('category updated', 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function category_delete($id)
    {
        $categories = Category::find($id);

        if ($categories) {
            $categories->delete();
            return response()->json('category deleted', 200);
        } else {
            return response()->json('category not found', 404);
        }
    }
}