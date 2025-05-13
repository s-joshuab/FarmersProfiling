<?php

namespace App\Http\Controllers\Admin;

use App\Models\crops;
use App\Models\Barangay;
use App\Models\Benefits;
use App\Models\Barangays;
use App\Models\Commodities;
use Illuminate\Http\Request;
use App\Models\FarmersProfile;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

date_default_timezone_set('Asia/Manila');

class ReportsController extends Controller
{
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'username', 'user_type']);
    }

    public function reports(Request $request)
    {
        $selectedBarangay = $request->input('barangayFilter');
        $selectedCommodities = $request->input('commoditiesFilter');
        $selectedStatus = $request->input('statusFilter');

        $farmersQuery = FarmersProfile::query();

        if ($selectedBarangay) {
            $farmersQuery->where('barangays_id', $selectedBarangay);
        }

        if ($selectedStatus) {
            $farmersQuery->where('status', $selectedStatus);
        }

        $farmersQuery->with(['crops' => function ($query) {
            // Select only the columns you need from the crops table
            $query->select('id', 'commodities_id', 'farm_size', 'farm_location', 'farmersprofile_id');
        }]);

        $farmers = $farmersQuery->get();
        $barangays = Barangays::all();
        $commodities = Commodities::all();
        $farm = FarmersProfile::paginate(10);

        // Loop through each farmer and update the crops relationship to include farm_size and farm_location
        foreach ($farmers as $farmer) {
            $farmer->crops->each(function ($crop) use ($selectedCommodities) {
                $crop->farm_size = $crop->farm_size ?? 'No Data';
                $crop->farm_location = $crop->farm_location ?? 'No Data';

                // Filter crops based on selected commodities
                if (!empty($selectedCommodities)) {
                    if (!in_array($crop->commodities_id, $selectedCommodities)) {
                        $crop->farm_size = 'No Data';
                        $crop->farm_location = 'No Data';
                    }
                }
            });
        }

        return view('admin.reports.index', compact('farm', 'farmers', 'barangays', 'commodities', 'selectedBarangay', 'selectedCommodities', 'selectedStatus'));
    }


    public function search(Request $request)
    {
        $selectedBarangay = $request->input('barangayFilter');
        $selectedCommodities = $request->input('commoditiesFilter');
        $selectedStatus = $request->input('statusFilter');

        $farmersQuery = FarmersProfile::query();

        if ($selectedBarangay) {
            $farmersQuery->where('barangays_id', $selectedBarangay);
        }

        if ($selectedStatus) {
            $farmersQuery->where('status', $selectedStatus);
        }

        $farmersQuery->with(['crops' => function ($query) {
            // Select only the columns you need from the crops table
            $query->select('id', 'commodities_id', 'farm_size', 'farm_location', 'farmersprofile_id');
        }]);

        $farmers = $farmersQuery->get();
        $barangays = Barangays::all();
        $commodities = Commodities::all();
        $farm = FarmersProfile::paginate(10);

        // Loop through each farmer and update the crops relationship to include farm_size and farm_location
        foreach ($farmers as $farmer) {
            $farmer->crops->each(function ($crop) use ($selectedCommodities) {
                $crop->farm_size = $crop->farm_size ?? 'No Data';
                $crop->farm_location = $crop->farm_location ?? 'No Data';

                // Filter crops based on selected commodities
                if (!empty($selectedCommodities)) {
                    if (!in_array($crop->commodities_id, $selectedCommodities)) {
                        $crop->farm_size = 'No Data';
                        $crop->farm_location = 'No Data';
                    }
                }
            });
        }

        return view('admin.reports.search', compact('farm', 'farmers', 'barangays', 'commodities', 'selectedBarangay', 'selectedCommodities', 'selectedStatus'));
    }


    public function commodities()
    {
        // Fetch data from the crops table
        $data = Crops::join('barangays', 'crops.barangays_id', '=', 'barangays.id')
            ->join('commodities', 'crops.commodities_id', '=', 'commodities.id')
            ->select('barangays as barangay', 'commodities as commodity', DB::raw('COUNT(*) as count'))
            ->groupBy('barangay', 'commodity')
            ->orderBy('barangay') // Order by barangay to make sure we get the max count for each barangay
            ->orderByDesc('count')
            ->get()
            ->unique('barangay'); // Take only the first row for each barangay (highest count)

        return view('admin.reports.commodities', compact('data'));
    }

    public function benefits()
    {
        // Retrieve data from the benefits table and eager load the associated farmersProfile
        $benefits = Benefits::with('farmersProfile')->get();

        // Pass the data to the view
        return view('admin.reports.benefits', compact('benefits'));
    }



}
