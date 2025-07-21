<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Repositories\Uploads\ImagenRepository;

class ProductsController extends Controller
{
    public function showAll(Request $request){
        return Product::all();
    }
    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'sometimes|image',
            'discountPercentage' => 'sometimes|numeric|min:0|max:100',
        ]);
        $coupon = Product::create($validatedData);

        return response()->json($coupon, 201);
    }
    public function destroy(Request $request, $id){
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted']);
    }
    public function update(Request $request, $id){
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->update($request->all());
        return response()->json($product);
    }

    public function showCategory(Request $request, $id){
        return Product::where('category_id', $id)->get();
    }

    public function show(Request $request, $id){
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product);
    }

    public function stock(Request $request, $id){
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product->stock);
    }

    public function image(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $coverPath = new ImagenRepository();
        $filePath = $coverPath->uploadPublicImage($request);

        $product->image = $filePath;
        $product->save();

        return response()->json(['file_path' => $filePath]);
    }
}
