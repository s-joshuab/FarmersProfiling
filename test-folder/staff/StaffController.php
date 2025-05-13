<?php

namespace App\Http\Controllers\staff;

use App\Models\User;
use App\Models\crops;
use App\Models\Barangays;
use App\Models\Commodities;
use Illuminate\Http\Request;
use App\Models\FarmersProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function staff()
    {
        $barangays = Barangays::all();
        $farmerCount = FarmersProfile::count();
        $user = User::count();
        $benefits = FarmersProfile::where('benefits', 'yes')->count();
        $status = FarmersProfile::where('status', 'Active')->count();

        $maleCount = FarmersProfile::where('sex', 'Male')->count();
        $femaleCount = FarmersProfile::where('sex', 'Female')->count();
        // Fetch unique commodities_id values from the Crops table
        $commoditiesIds = crops::distinct('commodities_id')->pluck('commodities_id')->toArray();

        // Initialize an array to store commodity names
        $commodityNames = [];

        // Count the number of occurrences of each commodities_id in the Crops table
        $commodityCounts = [];
        foreach ($commoditiesIds as $commodityId) {
            $count = crops::where('commodities_id', $commodityId)->count();
            $commodityCounts[] = $count;

            // Fetch and store the commodity name based on the commodities_id
            $commodityName = Commodities::find($commodityId)->commodities;
            $commodityNames[] = $commodityName;
        }

        return view('staff.staff', compact('farmerCount', 'benefits', 'status', 'user', 'commodityCounts', 'commodityNames', 'commoditiesIds', 'maleCount',
         'femaleCount', 'barangays'));
    }

    public function FarmerCount($id)
    {
        // Fetch the barangay name and count of farmers
        $barangay = Barangays::find($id);
        $farmerCount = FarmersProfile::where('barangays_id', $id)->count();

        return response()->json([
            'barangayName' => $barangay->name,
            'farmerCount' => $farmerCount,
        ]);
    }


    public function AllFarmersCount()
{
    $farmerCount = FarmersProfile::count();

    return response()->json([
        'barangayName' => 'All Barangay',
        'farmerCount' => $farmerCount,
    ]);
}

public function StatusCount($status)
{
    // Fetch the count of items based on the selected status filter
    $count = FarmersProfile::where('status', $status)->count();

    return response()->json([
        'count' => $count,
    ]);
}











    /**
     * Show the form for creating a new resource.
     */
    // public function farmdata()
    // {
    //     return view('staff.farmers.farmdata');
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function reports()
    // {
    //     return view('admin.farmers.reports');
    // }

    /**
     * Display the specified resource.
     */

    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
