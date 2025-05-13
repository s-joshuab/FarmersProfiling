<?php

namespace App\Http\Controllers;
use App\Models\Commodities;
use App\Models\Crops;
use App\Models\Machine;
use App\Models\Provinces;
use Illuminate\Http\Request;

class TestControllerCrops extends Controller
{
public function index() {
        $commodities = Commodities::where('category', 0)->pluck('commodities', 'id')->all();
    return view('croptest' , compact('commodities'));
}

public function store(Request $request)
{
    $selectedCommodities = $request->input('selected_commodities', []);
    $farmSizes = $request->input('farm_size', []);
    $locations = $request->input('farm_location', []);



//sample la atoy
    foreach ($selectedCommodities as $id => $commodityId) {
        Crops::create([
            'commodities_id' => $commodityId,
            'farm_size' => $farmSizes[$commodityId],
            'farm_location' => $locations[$commodityId],
        ]);
    }

    // $profile = Profile::create([
    //     'name' => name
    // ])

    //kastoy ton
    //if addan to profilenn//
    // foreach ($selectedCommodities as $id => $commodityId) {
    //     $profile->crops->create([
    //         'profile_id' => $profile,
    //         'commodities_id' => $commodityId,
    //         'farm_size' => $farmSizes[$commodityId],
    //         'farm_location' => $locations[$commodityId],
    //     ]);
    // }

    return redirect()->back()->with('success', 'Selected commodities saved successfully.');
}



}
