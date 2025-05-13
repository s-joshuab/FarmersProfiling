<?php

namespace App\Http\Controllers\staff;


use App\Models\User;
use App\Models\Barangays;
use App\Models\Provinces;
use App\Models\AuditTrail;
use App\Models\ImageUpload;
use Illuminate\Http\Request;
use App\Models\Municipalities;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class StaffSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function audit()
    {
        $activities = Activity::all();
        return view('staff.settings.audittrail', compact('activities'));
    }


    public function profile()
{
    $user = Auth::user(); // Fetch the authenticated user
    $provinces = Provinces::all();
    $municipalities = Municipalities::all();
    $barangays = Barangays::all();
    // Fetch additional data as needed
    $someData = User::where('id', $user->id)->get(); // Replace with your actual query

    return view('staff.settings.profile', compact('user', 'provinces', 'municipalities', 'barangays', 'someData'));
}


public function updateProfile(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Validate the form data for updating user details
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => [
            'required',
            'email',
            Rule::unique('users')->ignore($user->id),
        ],
        'phone_number' => 'required|numeric',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Validation failed.');
    }

    // Update the user's profile information
    $user->update([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'phone_number' => $request->input('phone_number'),
    ]);

    // Handle profile image upload if a new image was provided
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageData = base64_encode(file_get_contents($image->getPathname()));

        // Update the user's profile image data in the database
        $user->image = $imageData;
        $user->save();
    }

    return redirect('staff/profile')->with('success', 'Profile updated successfully');
}


public function updatePassword(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error occurred during password update.');
    }

    // Verify the current password
    if (!Hash::check($request->input('current_password'), $user->password)) {
        return redirect()->back()->withInput()->with('error', 'Current password is incorrect.');
    }

    $user->update([
        'password' => bcrypt($request->input('new_password')),
    ]);

    // Redirect to a success page or show a success message
    return redirect('staff/profile')->with('success', 'Password updated successfully.');
}







    public function backup()
    {
        return view('staff.settings.sysbackup');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
