<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Categories extends Controller
{
    public function show(Request $request){
        $categories = $request->user()->categories;
        return response()->json($categories);
    }

    public function store(Request $request){
        $request->user()->categories()->create($request->all());
        return response()->json($request->all());
    }

    public function destroy(Request $request, $id){
       $request->user()->categories()->find($id)->delete();
    }
    public function update(Request $request, $id){
        $request->user()->categories()->find($id)->update($request->all());
    }
}
