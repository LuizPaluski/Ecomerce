<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function show(Request $request){
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(Request $request){
        $category = Category::create($request->all([
            'name',
            'description',
            'image',
        ]));
        return response()->json($category, 201);

    }

    public function destroy(Request $request, $id){
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        $category->delete();
        return response()->json(['message' => 'Category deleted']);
    }

    public function update(Request $request, $id){
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        $category->update($request->all());
        return response()->json($category);
    }
}
