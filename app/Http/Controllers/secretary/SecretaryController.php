<?php

namespace App\Http\Controllers\secretary;

use App\Models\User;
use App\Models\Barangays;
use App\Models\Provinces;
use App\Models\Municipalities;
use App\Models\Commodities;
use Illuminate\Http\Request;
use App\Models\FarmersProfile;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SecretaryController extends Controller
{
    public function farmdata(Request $request)
    {
        $user = Auth::user();
        $selectedBarangay = $request->input('barangayFilter');
        $selectedCommodity = $request->input('commoditiesFilter');
        $selectedStatus = $request->input('statusFilter'); // Add status filter

        $farmersQuery = FarmersProfile::where('barangays_id', $user->barangays_id);

        if ($selectedBarangay) {
            $farmersQuery->where('barangays_id', $selectedBarangay);
        }

        if ($selectedCommodity) {
            $farmersQuery->whereHas('crops', function ($q) use ($selectedCommodity) {
                $q->whereIn('commodities_id', [$selectedCommodity]);
            });
        }

        if ($selectedStatus) {
            $farmersQuery->where('status', $selectedStatus);
        }

        $farmers = $farmersQuery->get();
        $barangays = Barangays::all();
        $commodities = Commodities::all();
        $farm = FarmersProfile::paginate(10); // Change '10' to the number of records per page you desire


        // You don't need to retrieve statuses separately; they are hardcoded in the dropdown

        return view('secretary.secretary.index', compact('farm', 'farmers', 'barangays', 'commodities', 'selectedBarangay', 'selectedCommodity', 'selectedStatus'));
    }


    public function profile()
    {
        $user = Auth::user(); // Fetch the authenticated user
        $provinces = Provinces::all();
        $municipalities = Municipalities::all();
        $barangays = Barangays::all();
        // Fetch additional data as needed
        $someData = User::where('id', $user->id)->get(); // Replace with your actual query

        return view('secretary.secretary.profile', compact('user', 'provinces', 'municipalities', 'barangays', 'someData'));
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
        $updatedAttributes = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
        ];

        // Handle profile image upload if a new image was provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageData = base64_encode(file_get_contents($image->getPathname()));

            // Update the user's profile image data in the database
            $user->image = $imageData;
            $user->save();
        }

        activity()
            ->causedBy(auth()->user()) // Assuming you're logged in
            ->performedOn($user) // The user being updated
            ->withProperties(['attributes' => $updatedAttributes]) // Include updated attributes
            ->log('Updated his/her profile');

        // Update the user's attributes
        $user->update($updatedAttributes);

        return redirect('profilee')->with('success', 'Profile updated successfully');
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

        $updatedAttributes = [
            'password' => bcrypt($request->input('new_password')),
        ];

        activity()
            ->causedBy(auth()->user()) // Assuming you're logged in
            ->performedOn($user) // The user being updated
            ->withProperties(['attributes' => $updatedAttributes]) // Include updated attributes
            ->log('Updated his/her password');

        // Update the user's attributes
        $user->update($updatedAttributes);

        // Redirect to a success page or show a success message
        return redirect('profilee')->with('success', 'Password updated successfully.');
    }
}
