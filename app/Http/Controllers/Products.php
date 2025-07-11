<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class Products extends Controller
{
    public function showAll(Request $request){
        return $request->user()->products;
    }
    public function store(Request $request){
        $request->user()->products()->create($request->all());
    }
    public function destroy(Request $request, $id){
        $request->user()->products()->find($id)->delete();
    }
    public function update(Request $request, $id){
        $request->user()->products()->find($id)->update($request->all());
    }

    public function showCategory(Request $request, $id){
        return $request->user()->products()->where('category_id', $id)->get();
    }

    public function show(Request $request, $id){
        return $request->user()->products()->find($id);
    }

    public function stock(Request $request, $id){
        $product = $request->user()->products()->find($id);
        return response()->json($product->stock);
    }

    public function image(Request $request, $id){
        $product = $request->user()->products()->find($id);
        return response()->json($product->image);
    }
}
