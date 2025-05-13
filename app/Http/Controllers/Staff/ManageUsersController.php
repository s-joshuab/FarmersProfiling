<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Barangays;
use App\Models\Provinces;
use Illuminate\Http\Request;
use App\Models\Municipalities;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\LogOptions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Traits\LogsActivity;

class ManageUsersController extends Controller
{
    use LogsActivity;

    /**
     * Display a listing of the resource.
     */

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'username', 'email', 'phone_number', 'user_type', 'status', 'provinces_id', 'municipalities_id', 'barangays_id']);
    }

    public function manage()
    {
        $users = User::all();
        return view('admin.settings.users.manageusers', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // You can add logic here if needed for user creation.
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $provinces = Provinces::all();
        $municipalities = Municipalities::all();
        $barangays = Barangays::all();
        return view('admin.settings.users.view', compact('user', 'provinces', 'municipalities', 'barangays'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $provinces = Provinces::all();
        $municipalities = Municipalities::all();
        $barangays = Barangays::all();
        return view('admin.settings.users.edit', compact('user', 'provinces', 'municipalities', 'barangays'));
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

        // Create an array with the updated attributes for comparison
        $updatedAttributes = [
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')), // Hash the password
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'user_type' => $request->input('user_type'),
            'status' => $request->input('status'),
            'provinces_id' => $request->input('provinces_id'),
            'municipalities_id' => $request->input('municipalities_id'),
            'barangays_id' => $request->input('barangays_id'),
        ];

        // Log the update activity
        activity()
            ->causedBy(auth()->user()) // Assuming you're logged in
            ->performedOn($user) // The user being updated
            ->withProperties(['attributes' => $updatedAttributes]) // Include updated attributes
            ->log('User updated');

        // Update the user's attributes
        $user->update($updatedAttributes);

        // Redirect to a success page or show a success message
        return redirect('admin/manageusers')->with('message', 'User Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
}
