<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class Addresses extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->user()->addresses()->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        $address->load('user');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        $request->user()->adresses()->all();
        $address->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();
    }
}
