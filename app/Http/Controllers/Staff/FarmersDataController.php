<?php

namespace App\Http\Controllers\Admin;


use App\Models\Crops;
use App\Models\QrCode;
use App\Models\Machine;
use App\Models\Barangays;
use App\Models\Provinces;
use App\Models\Commodities;
use App\Models\Machineries;
use Illuminate\Http\Request;
use App\Models\FarmersNumber;
use App\Models\FarmersProfile;
use App\Models\Municipalities;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Traits\LogsActivity;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeFacade;


class FarmersDataController extends Controller
{

    use LogsActivity;

    /**
     * Display a listing of the resource.
     */

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'username','user_type']);
    }

    public function farmdata(Request $request)
    {
        $selectedBarangay = $request->input('barangayFilter');
        $selectedCommodity = $request->input('commoditiesFilter');
        $selectedStatus = $request->input('statusFilter'); // Add status filter

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

        $farmers = $farmersQuery->get();
        $barangays = Barangays::all();
        $commodities = Commodities::all();
        $farm = FarmersProfile::paginate(10); // Change '10' to the number of records per page you desire


        // You don't need to retrieve statuses separately; they are hardcoded in the dropdown

        return view('admin.farmers.index', compact('farm', 'farmers', 'barangays', 'commodities', 'selectedBarangay', 'selectedCommodity', 'selectedStatus'));
    }



    public function generate($id)
    {
        $ids = [$id];
        $farmers = FarmersProfile::whereIn('id', $ids)->get();
        return view('admin.farmers.id', compact('farmers'));
    }



    public function create(Request $request)
    {
        $provinces = Provinces::all();
        $commodities = Commodities::where('category', 0)->pluck('commodities', 'id')->all();
        $farmers = Commodities::where('category', 1)->pluck('commodities', 'id')->all();
        $machine = Machine::pluck('machine', 'id')->all();

        return view('admin.farmers.create', compact('commodities', 'farmers', 'machine', 'provinces'));
    }

    public function getMunicipalities($province_id)
    {
        $municipalities = Municipalities::where('provinces_id', $province_id)->get();
        return response()->json($municipalities);
    }

    public function getBarangays($municipality_id)
    {
        $barangays = Barangays::where('municipalities_id', $municipality_id)->get();
        return response()->json($barangays);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ref_no' => 'required',
            'status' => 'required',
            'sname' => 'required',
            'fname' => 'required',
            'mname' => 'required',
            'ename' => 'required',
            'sex' => 'required',
            'spouse' => 'nullable',
            'number' => 'required',
            'mother' => 'required',
            'regions' => 'required',
            'provinces_id' => 'required',
            'municipalities_id' => 'required',
            'barangays_id' => 'required|exists:barangays,id',
            'purok' => 'required',
            'house' => 'required',
            'dob' => 'required|date',
            'pob' => 'required',
            'religion' => 'required',
            'cstatus' => 'required',
            'education' => 'required',
            'pwd' => 'required',
            'benefits' => 'required',
            'livelihood' => 'required',
            'gross' => 'required',
            'grosses' => 'required',
            'parcels' => 'required',
            'arb' => 'required',
            // Add other validation rules for other fields here if needed
        ]);

        if ($validator->fails()) {
            dd($validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error occurred during Adding.');
        }

        // Create the farmer profile using the FarmersProfile model
        $farmersprofile = FarmersProfile::create([
            'ref_no' => $request->input('ref_no'),
            'status' => $request->input('status'),
            'sname' => $request->input('sname'),
            'fname' => $request->input('fname'),
            'mname' => $request->input('mname'),
            'ename' => $request->input('ename'),
            'sex' => $request->input('sex'),
            'spouse' => $request->input('spouse'),
            'mother' => $request->input('mother'),
            'number' => $request->input('number'),
            'regions' => $request->input('regions'),
            'provinces_id' => $request->input('provinces_id'),
            'municipalities_id' => $request->input('municipalities_id'),
            'barangays_id' => $request->input('barangays_id'),
            'purok' => $request->input('purok'),
            'house' => $request->input('house'),
            'dob' => $request->input('dob'),
            'pob' => $request->input('pob'),
            'religion' => $request->input('religion'),
            'cstatus' => $request->input('cstatus'),
            'education' => $request->input('education'),
            'pwd' => $request->input('pwd'),
            'benefits' => $request->input('benefits'),
            'livelihood' => $request->input('livelihood'),
            'gross' => $request->input('gross'),
            'grosses' => $request->input('grosses'),
            'parcels' => $request->input('parcels'),
            'arb' => $request->input('arb')
            // Add other attributes here if needed
        ]);

        $selectedCommodities = $request->input('crops', []);
        $farmSizes = $request->input('farm_size', []);
        $farmLocations = $request->input('farm_location', []);

        foreach ($selectedCommodities as $id => $commodityId) {
            $farmersprofile->crops()->create([
                'commodities_id' => $commodityId,
                'farm_size' => $farmSizes[$commodityId],
                'farm_location' => $farmLocations[$commodityId],
            ]);
        }
        $selectedMachineries = $request->input('machineries', []);
        $units = $request->input('units', []);

        foreach ($selectedMachineries as $id => $machineId) {
            $farmersprofile->machineries()->create([
                'machine_id' => $machineId,
                'units' => $units[$machineId],
            ]);
        }

        $barangaysId = $request->input('barangays_id');
        $existingBarangay = Barangays::find($barangaysId);

        // Find the existing FarmersNumber record associated with the FarmersProfile
        $farmersNumber = FarmersNumber::where('farmersprofile_id', $farmersprofile->id)->first();

        if (!$farmersNumber) {
            // If there's no existing record, create a new one
            $attributes = [
                'barangays_id' => $barangaysId,
                'farmersprofile_id' => $farmersprofile->id,
            ];

            $farmersNumber = $this->createFarmersNumber($attributes);
        }

        $qrCodeContent = json_encode([
            'farmersnumber' => $farmersprofile->farmersNumbers->first()->farmersnumber,
            'sname' => $farmersprofile->sname,
            'regions' => $farmersprofile->regions,
            'provinces_id' => $farmersprofile->provinces,
            'municipalities_id' => $farmersprofile->municipalities,
            'barangays_id' => $farmersprofile->barangays,
            // Add more attributes as needed
        ]);


        // Generate QR code image using the QrCode facade
        $qrCodeImage = QrCodeFacade::format('png')->generate($qrCodeContent);

        // Save QR code image to storage using the Storage facade
        $qrCodeImagePath = 'public/qr_codes/' . $farmersprofile->id . '.png';
        Storage::put($qrCodeImagePath, $qrCodeImage);

        // Save QR code image path to the database using the QrCode model
        QrCode::create([
            'farmersprofile_id' => $farmersprofile->id,
            'qr_code_data' => $qrCodeImagePath, // Make sure this matches the attribute in the $fillable array
        ]);

        activity()
            ->causedBy(auth()->user()) // Assuming you're logged in
            ->performedOn($farmersprofile) // The user being created
            ->log('Added Farmers Informations');

        return redirect('admin/farmreport')->with('message', 'Farmer Added Successfully!');
    }

    //gegenerate ng ng id number
    protected function createFarmersNumber(array $attributes)
    {
        $count = FarmersNumber::where('barangays_id', $attributes['barangays_id'])->count();
        $count++;
        $attributes['farmersnumber'] = "BLN {$attributes['barangays_id']} - {$count}";
        return FarmersNumber::create($attributes);
    }


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

    public function edit(string $id)
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

        return view('admin.farmers.update', compact(
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

    public function update(Request $request, $id)
    {
        $farmersprofile = FarmersProfile::findorfail($id);

        $validator = Validator::make($request->all(), [
            'ref_no' => 'required',
            'status' => 'required',
            'sname' => 'required',
            'fname' => 'required',
            'mname' => 'required',
            'ename' => 'required',
            'sex' => 'required',
            'spouse' => 'nullable',
            'number' => 'required',
            'mother' => 'required',
            'regions' => 'required',
            'provinces_id' => 'required',
            'municipalities_id' => 'required',
            'barangays_id' => 'required',
            'purok' => 'required',
            'house' => 'required',
            'dob' => 'required|date',
            'pob' => 'required',
            'religion' => 'required',
            'cstatus' => 'required',
            'education' => 'required',
            'pwd' => 'required',
            'benefits' => 'required',
            'livelihood' => 'required',
            'gross' => 'required',
            'grosses' => 'required',
            'parcels' => 'required',
            'arb' => 'required',
            // Add other validation rules for other fields here if needed
        ]);

        if ($validator->fails()) {
            dd($validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error occurred during Adding.');
        }

        // update part
        $updatedAttributes = [
            'ref_no' => $request->input('ref_no'),
            'status' => $request->input('status'),
            'sname' => $request->input('sname'),
            'fname' => $request->input('fname'),
            'mname' => $request->input('mname'),
            'ename' => $request->input('ename'),
            'sex' => $request->input('sex'),
            'spouse' => $request->input('spouse'),
            'mother' => $request->input('mother'),
            'number' => $request->input('number'),
            'regions' => $request->input('regions'),
            'provinces_id' => $request->input('provinces_id'),
            'municipalities_id' => $request->input('municipalities_id'),
            'barangays_id' => $request->input('barangays_id'),
            'purok' => $request->input('purok'),
            'house' => $request->input('house'),
            'dob' => $request->input('dob'),
            'pob' => $request->input('pob'),
            'religion' => $request->input('religion'),
            'cstatus' => $request->input('cstatus'),
            'education' => $request->input('education'),
            'pwd' => $request->input('pwd'),
            'benefits' => $request->input('benefits'),
            'livelihood' => $request->input('livelihood'),
            'gross' => $request->input('gross'),
            'grosses' => $request->input('grosses'),
            'parcels' => $request->input('parcels'),
            'arb' => $request->input('arb')
            // Add other attributes here if needed
        ];

        $selectedCommodities = $request->input('crops', []);
        $farmSizes = $request->input('farm_size', []);
        $farmLocations = $request->input('farm_location', []);

        // Delete old crops data not present in the current input
        $farmersprofile->crops()
            ->whereNotIn('commodities_id', $selectedCommodities)
            ->delete();

        foreach ($selectedCommodities as $id => $commodityId) {
            $cropData = [
                'commodities_id' => $commodityId,
                'farm_size' => $farmSizes[$id],
                'farm_location' => $farmLocations[$id],
            ];

            $farmersprofile->crops()->updateOrCreate(
                ['commodities_id' => $commodityId],
                $cropData
            );

            // Update or store farm_size and farm_location in the FarmersProfile itself
            $farmersprofile->update([
                'farm_size' => $farmSizes[$id],
                'farm_location' => $farmLocations[$id],
            ]);
        }

        $selectedMachineries = $request->input('machineries', []);
        $units = $request->input('units', []);

        // Delete old machineries data not present in the current input
        $farmersprofile->machineries()
            ->whereNotIn('machine_id', $selectedMachineries)
            ->delete();

        foreach ($selectedMachineries as $id => $machineId) {
            $machineryData = [
                'machine_id' => $machineId,
                'units' => $units[$id],
            ];

            $farmersprofile->machineries()->updateOrCreate(
                ['machine_id' => $machineId],
                $machineryData
            );

            // Update or store units in the FarmersProfile itself
            $farmersprofile->update([
                'units' => $units[$id],
            ]);
        }

        $barangaysId = $request->input('barangays_id');
        $existingBarangay = Barangays::find($barangaysId);

        // Find the existing FarmersNumber record associated with the FarmersProfile
        $farmersNumber = FarmersNumber::where('farmersprofile_id', $farmersprofile->id)->first();

        if (!$farmersNumber) {
            // If there's no existing record, create a new one
            $attributes = [
                'barangays_id' => $barangaysId,
                'farmersprofile_id' => $farmersprofile->id,
            ];

            $farmersNumber = $this->createFarmersNumber($attributes);
        } else {
            // If there's an existing record and the barangays_id is different, update it
            if ($farmersNumber->barangays_id !== $barangaysId) {
                $lastFarmersNumber = FarmersNumber::where('barangays_id', $barangaysId)->orderByDesc('id')->first();

                if ($lastFarmersNumber) {
                    // Extract the current count from the last farmersnumber
                    $lastFarmersNumberParts = explode(' - ', $lastFarmersNumber->farmersnumber);
                    $count = intval($lastFarmersNumberParts[1]) + 1;
                } else {
                    $count = 1;
                }

                $newFarmersNumber = "BLN {$barangaysId} - {$count}";
                $farmersNumber->update(['farmersnumber' => $newFarmersNumber]);
            }
        }


        activity()
            ->causedBy(auth()->user()) // Assuming you're logged in
            ->performedOn($farmersprofile) // The FarmersProfile being updated
            ->withProperties(['attributes' => $updatedAttributes]) // Include updated attributes
            ->log('Update Farmers Profile');

        // Update the FarmersProfile's attributes
        $farmersprofile->update($updatedAttributes);

        return redirect('admin/farmreport')->with('message', 'Farmers Data Update Successfully!');
    }
}
