<?php

namespace App\Http\Controllers\staff;

use App\Models\User;
use App\Models\Provinces;
use App\Models\Barangays;
use App\Models\Municipalities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class StaffUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function users(Request $request)
    {
        $users = User::all();
        return view('staff.users', compact('users'));
    }

    public function getMunicipalities($province_id)
    {
        $municipalities = Municipalities::where('provinces_id', $province_id)->get();
        return response()->json($municipalities);
    }

    public function getBarangays($municipality_id)
    {
        $barangays = Barangays::where('municipalities_id', $municipality_id)->get();
        return response()->json($barangays);
    }

    public function store(Request $request)
    {

    // Check if username or email is duplicate
    if (User::where('username', $request->username)->exists() || User::where('email', $request->email)->exists()) {
        session()->flash('error', 'Username or email is already taken.');
        return redirect()->back();
    }

    // Add the user to the database
    $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone_number' => 'required',
            'status' => 'required',
            'user_type' => 'required',
            'provinces_id' => 'required',
            'municipalities_id' => 'required',
            'barangays_id' => 'required|exists:barangays,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error occurred during Adding.');
        }

        User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'phone_number' => $request->input('phone_number'),
            'status' => $request->input('status'),
            'user_type' => $request->input('user_type'),
            'provinces_id' => $request->input('provinces_id'),
            'municipalities_id' => $request->input('municipalities_id'),
            'barangays_id' => $request->input('barangays_id'),
        ]);


        return redirect('staff/manageusers')->with('message', 'User Added Succesfully!');
    }



    /**
     * Display the specified resource.
     */
    public function create()
    {
        $provinces = Provinces::all();
        return view('staff.users', compact('provinces'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
