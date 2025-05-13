<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\crops;
use App\Models\Barangays;
use App\Models\Commodities;
use Illuminate\Http\Request;
use App\Models\FarmersProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
date_default_timezone_set('Asia/Manila');
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function admin()
    {
        $barangays = Barangays::all();
        $farmerCount = FarmersProfile::count();
        $user = User::count();
        $benefits = FarmersProfile::where('benefits', 'yes')->count();
        $status = FarmersProfile::where('status', 'Active')->count();

        $maleCount = FarmersProfile::where('sex', 'Male')->count();
        $femaleCount = FarmersProfile::where('sex', 'Female')->count();
        $activeStatusCount = FarmersProfile::where('status', 'Active')->count();

        // Fetch the count of inactive farmers
        $inactiveStatusCount = FarmersProfile::where('status', 'Inactive')->count();
        // Fetch unique commodities_id values from the Crops table
        $commoditiesIds = crops::distinct('commodities_id')->pluck('commodities_id')->toArray();

        // Initialize variables to store commodity names and counts
        $commodityNames = [];
        $commodityCounts = [];

        $maxCommodityCounts = []; // Initialize an array to store counts of the highest commodities
        $maxCommodities = []; // Initialize an array to store commodities with the highest count

        foreach ($commoditiesIds as $commodityId) {
            // Exclude records with null commodities_id
            if (!is_null($commodityId)) {
                $count = crops::where('commodities_id', $commodityId)->count();

                if (empty($maxCommodityCounts) || $count > max($maxCommodityCounts)) {
                    // If this commodity has a higher count, clear the previous counts
                    $maxCommodityCounts = [$count];
                    $maxCommodities = [];
                }

                if ($count == max($maxCommodityCounts)) {
                    // If this commodity has the same highest count, add its count to the list
                    $commodity = Commodities::find($commodityId);
                    $commodityName = $commodity ? $commodity->commodities : "Unknown";
                    $maxCommodities[] = ['name' => $commodityName, 'count' => $count];
                }

                $commodityCounts[] = $count;

                // Fetch and store the commodity name based on the commodities_id
                $commodity = Commodities::find($commodityId);
                if ($commodity) {
                    $commodityName = $commodity->commodities;
                    $commodityNames[] = $commodityName;
                } else {
                    $commodityNames[] = "Unknown"; // Provide a default value for missing commodities
                }
            }
        }

        // Find the maximum commodity count and its corresponding name and ID
        if (!empty($commodityCounts)) {
    $maxCommodityIndex = array_search(max($commodityCounts), $commodityCounts);

    if ($maxCommodityIndex !== false) {
        $maxCommodityCount = $commodityCounts[$maxCommodityIndex];
        $maxCommodityName = $commodityNames[$maxCommodityIndex];
        $maxCommodityId = $commoditiesIds[$maxCommodityIndex];
    } else {
        // Set default values even if there are no commodities
        $maxCommodityCount = 0;
        $maxCommodityName = "No Commodities";
        $maxCommodityId = null;
    }
} else {
    // Set default values if there are no commodities
    $maxCommodityCount = 0;
    $maxCommodityName = "No Commodities";
    $maxCommodityId = null;
}

// Now you can use $maxCommodityCount, $maxCommodityName, and $maxCommodityId as needed

        // Fetch the top 5 commodities
        $maxCommodityIndex = !empty($commodityCounts) ? array_search(max($commodityCounts), $commodityCounts) : false;

    if ($maxCommodityIndex !== false) {
        $maxCommodityCount = $commodityCounts[$maxCommodityIndex];
        $maxCommodityName = $commodityNames[$maxCommodityIndex];
        $maxCommodityId = $commoditiesIds[$maxCommodityIndex];
    } else {
        // Set default values if there are no commodities
        $maxCommodityCount = 0;
        $maxCommodityName = "No Commodities";
        $maxCommodityId = null;
    }

    // Fetch the top 5 commodities
    if (!empty($commodityCounts)) {
        $maxCommodityIndex = array_search(max($commodityCounts), $commodityCounts, true);

        $maxCommodityCount = ($maxCommodityIndex !== false) ? $commodityCounts[$maxCommodityIndex] : 0;
        $maxCommodityName = ($maxCommodityIndex !== false) ? $commodityNames[$maxCommodityIndex] : "No Commodities";
        $maxCommodityId = ($maxCommodityIndex !== false) ? $commoditiesIds[$maxCommodityIndex] : null;
    } else {
        // Set default values if there are no commodities
        $maxCommodityCount = 0;
        $maxCommodityName = "No Commodities";
        $maxCommodityId = null;
    }

    // Fetch the top 5 commodities
    $maxCommodities = $this->getTopCommodities($commodityCounts, $commodityNames, 5);

    return view('admin.admin', compact('maxCommodities', 'maxCommodityName', 'farmerCount', 'benefits', 'status', 'user', 'commodityCounts', 'commodityNames', 'commoditiesIds', 'maleCount', 'femaleCount', 'barangays', 'maxCommodityIndex', 'activeStatusCount', 'inactiveStatusCount', 'maxCommodityCount', 'maxCommodityId'));
}

// Add this method to your controller (replace 'YourController' with the actual name of your controller)
private function getTopCommodities($counts, $names, $limit)
{
    $topCommodities = [];

    foreach ($counts as $commodityId => $count) {
        $topCommodities[] = [
            'id' => $commodityId,
            'name' => $names[$commodityId] ?? "No Data", // Use "No Data" if the name is not set
            'count' => $count,
        ];
    }

    // Sort the topCommodities array based on count in descending order
    usort($topCommodities, function ($a, $b) {
        return $b['count'] - $a['count'];
    });

    // Take the top N commodities
    $topCommodities = array_slice($topCommodities, 0, $limit);

    return $topCommodities;
}


    public function getFarmerCount($id)
    {
        // Fetch the barangay name and count of farmers
        $barangay = Barangays::find($id);
        $farmerCount = FarmersProfile::where('barangays_id', $id)->count();

        return response()->json([
            'barangayName' => $barangay->name,
            'farmerCount' => $farmerCount,
        ]);
    }


    public function getAllFarmersCount()
{
    $farmerCount = FarmersProfile::count();

    return response()->json([
        'barangayName' => 'All Barangay',
        'farmerCount' => $farmerCount,
    ]);
}

public function getStatusCount($status)
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
    //     return view('admin.farmers.farmdata');
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
