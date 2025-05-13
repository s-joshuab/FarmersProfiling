<?php

namespace App\Http\Controllers\Admin;


use PDF;
use App\Exports\FarmersExport;
use App\Models\Barangays;
use App\Models\Commodities;
use Illuminate\Http\Request;
use App\Models\FarmersProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;


class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function reports(Request $request)
{
    $selectedBarangay = $request->input('barangayFilter');
    $selectedCommodity = $request->input('commoditiesFilter');
    $selectedStatus = $request->input('statusFilter');

    $farmersQuery = FarmersProfile::query();

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

    $farmers = $farmersQuery->with('crops')->get();
    $barangays = Barangays::all();
    $commodities = Commodities::all();
    $farm = FarmersProfile::paginate(10);

    return view('admin.reports.index', compact('farm', 'farmers', 'barangays', 'commodities', 'selectedBarangay', 'selectedStatus', 'selectedCommodity'));
}


    public function exportFarmers()
{
    return Excel::download(new FarmersExport(), 'farmers.xlsx');
}




    // public function generateExcel()
    // {
    //     return Excel::download(new FarmersExport(), 'farmers_report.xlsx');
    // }

    // public function generatePdf()
    // {
    //     $farmers = FarmersProfile::all();
    //     $pdf = PDF::loadView('admin.reports.index', compact('farmers'));
    //     return $pdf->stream('farmers_report.index');
    // }
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
