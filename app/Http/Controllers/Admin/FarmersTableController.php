<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Models\FarmersProfile;
use App\Models\Provinces;
use App\Models\Municipalities;
use App\Models\Barangays;
use App\Models\Commodities;
use App\Models\Machine      ;
use App\Http\Controllers\Controller;
date_default_timezone_set('Asia/Manila');
class FarmersTableController extends Controller
{
    public function show($id)
    {
        $farmersprofile = FarmersProfile::findOrFail($id);
        $crops = $farmersprofile->crops;
        $machineries = $farmersprofile->machineries;
        $provinces = Provinces::all();
        $municipalities = Municipalities::all();
        $barangays = Barangays::all();
        $commodities = Commodities::where('category', 0)->pluck('commodities', 'id')->all();
        $farmers = Commodities::where('category', 1)->pluck('commodities', 'id')->all();
        $machine = Machine::pluck('machine', 'id')->all();

        return view('admin.farmers.view', compact(
            'commodities',
            'farmers',
            'machine',
            'farmersprofile',
            'crops',
            'machineries',
            'provinces',
            'municipalities',
            'barangays'
        ));
    }
}

