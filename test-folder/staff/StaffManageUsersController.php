<?php

namespace App\Http\Controllers\staff;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Provinces;
use App\Models\Barangays;
use App\Models\Municipalities;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffManageUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        // Fetch only users with the role "Secretary"
        $secretaries = User::where('user_type', 'Secretary')->get();

        return view('staff.settings.users.manageusers', compact('secretaries'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findorfail($id);
        $provinces= Provinces::all();
        $municipalities = Municipalities::all();
        $barangays = Barangays::all();
        return view('staff.settings.users.view', compact('user', 'provinces', 'municipalities', 'barangays'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findorfail($id);
        $provinces= Provinces::all();
        $municipalities = Municipalities::all();
        $barangays = Barangays::all();
        return view('staff.settings.users.edit',compact('user', 'provinces', 'municipalities', 'barangays'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'required|numeric',
            'user_type' => 'required',
            'status' => 'required',
            'provinces_id' => 'required',
            'municipalities_id' => 'required',
            'barangays_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error occurred during user update.');
        }

        $user->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'user_type' => $request->input('user_type'),
            'status' => $request->input('status'),
            'provinces_id' => $request->input('provinces_id'),
            'municipalities_id' => $request->input('municipalities_id'),
            'barangays_id' => $request->input('barangays_id'),
        ]);

        // Redirect to a success page or show a success message
        return redirect('staff/manageusers')->with('message', 'User Updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
