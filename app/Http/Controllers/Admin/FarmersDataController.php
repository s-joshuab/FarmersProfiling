<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use App\Models\Crops;
use App\Models\Others;
use App\Models\Status;
use App\Models\machine;
use App\Models\Benefits;
use App\Models\Barangays;
use App\Models\provinces;
use App\Models\Commodities;
use App\Models\Machineries;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FarmersNumber;
use App\Models\FarmersProfile;
use App\Models\municipalities;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Models\HighestFormalEducation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Activitylog\Traits\LogsActivity;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeFacade;


date_default_timezone_set('Asia/Manila');
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
        $selectedCommodities = $request->input('commodityFilter');
        $selectedStatus = $request->input('statusFilter');

        $farmersQuery = FarmersProfile::query();

        // Filter by selected barangays
        if ($selectedBarangay) {
            $farmersQuery->where('barangays_id', $selectedBarangay);
        }

        // Filter by selected status
        if ($selectedStatus) {
            $farmersQuery->where('status', $selectedStatus);
        }

        // Additional filtering logic for commodities, if needed
        if ($selectedCommodities) {
            $farmersQuery->whereHas('crops', function ($query) use ($selectedCommodities) {
                $query->whereIn('commodities_id', $selectedCommodities);
            });
        }

        // Echo the SQL query
        // $sql = $farmersQuery->toSql();
        // dd($sql); // Remove or move this line to an appropriate place if you want to see the SQL query

        // Fetch data
        $farmers = $farmersQuery->get();
        $barangays = Barangays::all();
        $others = Others::all();
        $commodities = Commodities::all();


        $farm = FarmersProfile::paginate(10);

        return view('admin.farmers.index', compact('others', 'farm', 'farmers', 'barangays', 'commodities', 'selectedBarangay', 'selectedCommodities', 'selectedStatus'));

    }








    public function saveImage(Request $request)
    {
        // Get the image data URL from the request
        $imageDataUrl = $request->input('image');

        // Decode the data URL and save it to storage
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageDataUrl));

        // Generate a unique filename (you can customize this logic)
        $filename = 'farmer_id_' . time() . '.png';

        // Save the image to the storage path
        Storage::put('public/' . $filename, $imageData);

        return response()->json(['message' => 'Image saved successfully', 'filename' => $filename]);
    }


    public function generate($id)
    {
        $civilStatusOptions = Status::all();
        $users = User::all();
        $ids = [$id];
        $farmers = FarmersProfile::findOrFail($id);

        activity()
            ->causedBy(auth()->user()) // Assuming you're logged in
            ->performedOn($farmers) // The user being created
            ->log('View/Generate Farmer ID');
        return view('admin.farmers.id', compact('farmers', 'ids','users', 'civilStatusOptions'));
    }

       // public function getMunicipalities($province_id)
    // {
    //     $municipalities = Municipalities::where('provinces_id', $province_id)->get();
    //     return response()->json($municipalities);
    // }

    // public function getBarangays($municipality_id)
    // {
    //     $barangays = Barangays::where('municipalities_id', $municipality_id)->get();
    //     return response()->json($barangays);
    // }

    public function fetchCivilStatus(Request $request)
    {
        $selectedCivilStatusId = $request->input('civilstatusId');

        // Assuming your civil status model is named CivilStatus
        $civilStatusData = Status::find($selectedCivilStatusId);

        // Check if civil status data is found
        if (!$civilStatusData) {
            return response()->json(['error' => 'Civil status not found'], 404);
        }

        // You can return the fetched data as needed, for example, convert it to an array
        $data = [
            'civil_status_id' => $civilStatusData->id,
            'civil_status' => $civilStatusData->status,
            // Add other fields as needed
        ];

        return response()->json($data);
    }


    public function fetchEducationData(Request $request)
    {
        $selectedEducationId = $request->input('educationId');

        // Fetch data from the database based on the selected education level ID
        $educationData = HighestFormalEducation::find($selectedEducationId);

        // You can return the fetched data as needed, for example, convert it to an array
        $data = [
            'highest_formal_education_id' => $educationData->education,
            // Add other fields as needed
        ];

        return response()->json($data);
    }


    public function createAdd(Request $request)
    {
        $highest_formal_education = HighestFormalEducation::all();
        $civilStatusOptions = Status::all();
        $barangays = Barangays::all();
        $provinces = Provinces::all();
        $commodities = Commodities::where('category', 0)->pluck('commodities', 'id')->all();
        $others = Commodities::where('category', 3)->pluck('commodities', 'id')->all();
        $farmers = Commodities::where('category', 1)->pluck('commodities', 'id')->all();
        $machine = Machine::pluck('machine', 'id')->all();

        return view('admin.farmers.create', compact('others', 'commodities', 'civilStatusOptions', 'highest_formal_education', 'farmers', 'machine', 'provinces', 'barangays'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ref_no' => 'required',
            'status' => 'required',
            'sname' => 'required',
            'fname' => 'required',
            'mname' => 'nullable',
            'ename' => 'nullable',
            'sex' => 'required',
            'spouse' => 'nullable',
            'number' => 'required',
            'mother' => 'required',
            'emergency' => 'required',
            'regions' => 'required',
            'provinces_id' => 'required',
            'municipalities_id' => 'required',
            'barangays_id' => 'required|exists:barangays,id',
            'purok' => 'nullable',
            'house' => 'nullable',
            'dob' => 'required|date',
            'pob' => 'required',
            'religion' => 'required',
            'civil_status_id' => 'required',
            'highest_formal_education_id' => 'required',
            'pwd' => 'required',
            'benefits' => 'required',
            'livelihood' => 'required',
            'gross' => 'required',
            'grosses' => 'required',
            'parcels' => 'required',
            'arb' => 'required',
            // Add other validation rules for other fields here if needed
        ]);

        // if ($validator->fails()) {
        //     dd($validator->errors()->all());
        //     return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error occurred during Adding.');
        // }

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
            'emergency' => $request->input('emergency'),
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
            'civil_status_id' => $request->input('civil_status_id'),
            'highest_formal_education_id' => $request->input('highest_formal_education_id'),
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
            $barangaysId = $request->input('barangays_id', null);

            if (empty($selectedCommodities)) {
                // If no commodities are selected, save null values
                $farmersprofile->crops()->create([
                    'commodities_id' => null,
                    'farm_size' => null,
                    'farm_location' => null,
                    'barangays_id' => $barangaysId,
                ]);
            } else {
                // If commodities are selected, loop through them and save the data
                foreach ($selectedCommodities as $id => $commodityId) {
                    $farmersprofile->crops()->create([
                        'commodities_id' => $commodityId,
                        'farm_size' => $farmSizes[$commodityId],
                        'farm_location' => $farmLocations[$commodityId],
                        'barangays_id' => $barangaysId,
                    ]);
                }
            }

            $selectedCommodities = $request->input('others', null);
            $farmSizes = $request->input('farm_size', null);
            $farmLocations = $request->input('farm_location', null);
            $barangaysId = $request->input('barangays_id', null);

            if (empty($selectedCommodities)) {
                // If no commodity is specified, save null values
                $farmersprofile->others()->create([
                    'others' => null,
                    'farm_size' => null,
                    'farm_location' => null,
                    'barangays_id' => $barangaysId,
                ]);
            } else {
                // If a commodity is specified, save the data
                $farmersprofile->others()->create([
                    'others' => $selectedCommodities,
                    'farm_size' => $farmSizes, // Make sure farm_sizes is not null
                    'farm_location' => $farmLocations, // Make sure farm_locations is not null
                    'barangays_id' => $barangaysId,
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

        activity()
        ->causedBy(auth()->user()) // Assuming you're logged in
        ->performedOn($farmersprofile) // The user being created
        ->log('Added Farmer Informations');


        session()->flash('message', 'Farmer Added Successfully!');

        return redirect()->route('farmers.report')->with('message', 'Farmer Added Successfully!');


        // $qrCodeContent = $farmersprofile->id; // Use the ID of the FarmersProfile instance

        // Generate QR code image using the QrCode facade
        $qrCodeImage = QrCodeFacade::format('png');

        // Save QR code image to storage using the Storage facade
        $qrCodeImagePath = 'public/qr_codes/' . $farmersprofile->id . '.png';
        $qrCodeImagePath = FarmersProfile::findOrFail($farmersprofile);
        Storage::put($qrCodeImagePath, $qrCodeImage);

        // Do not save the QR code image data to the database, only save the path in the 'qr_code_data' colum
    }

public function createFarmersNumber(array $attributes)
{
    // Find the last farmersnumber for the given barangays_id
    $lastFarmersNumber = FarmersNumber::where('barangays_id', $attributes['barangays_id'])
        ->orderBy('farmersnumber', 'desc')
        ->first();

    // Extract the count from the last farmersnumber and increment it
    if ($lastFarmersNumber) {
        // Extract count from the last farmersnumber
        $lastCount = intval(substr($lastFarmersNumber->farmersnumber, strrpos($lastFarmersNumber->farmersnumber, '-') + 1));
        $count = $lastCount + 1;
    } else {
        $count = 1;
    }

    // Generate the new farmersnumber
    $farmersNumberValue = "BLN {$attributes['barangays_id']} - {$count}";

    // Create the new farmersnumber
    try {
        $farmersNumber = new FarmersNumber();
        $farmersNumber->farmersnumber = $farmersNumberValue;
        $farmersNumber->barangays_id = $attributes['barangays_id'];
        $farmersNumber->farmersprofile_id = $attributes['farmersprofile_id'];
        $farmersNumber->save();
        return $farmersNumber;
    } catch (\Exception $e) {
        // Handle duplicate entry scenario
        // You may want to throw an exception, log an error, or handle it in any other way suitable for your application
        // For now, let's just return null
        return null;
    }
}






    public function show($id)
    {
        $highest_formal_education = HighestFormalEducation::all();
        $civilStatusOptions = Status::all();
        $users = User::all();
        $farmersprofile = FarmersProfile::findOrFail($id);
        $crops = $farmersprofile->crops;
        $machineries = $farmersprofile->machineries;
        $provinces = provinces::all();
        $municipalities = municipalities::all();
        $barangays = Barangays::all();
        $others = Commodities::where('category', 3)->pluck('commodities', 'id')->all();
        $commodities = Commodities::where('category', 0)->pluck('commodities', 'id')->all();
        $farmers = Commodities::where('category', 1)->pluck('commodities', 'id')->all();
        $machine = machine::pluck('machine', 'id')->all();

        activity()
            ->causedBy(auth()->user()) // Assuming you're logged in
            ->performedOn($farmersprofile) // The user being created
            ->log('View Farmer Informations');

        return view('admin.farmers.view', compact(
            'others',
            'commodities',
            'highest_formal_education',
            'farmers',
            'machine',
            'farmersprofile',
            'civilStatusOptions',
            'crops',
            'machineries',
            'provinces',
            'municipalities',
            'barangays'
        ));
    }

    public function edit(string $id)
    {
        $highest_formal_education = HighestFormalEducation::all();
        $civilStatusOptions = Status::all();
        $farmersprofile = FarmersProfile::findOrFail($id);
        $crops = $farmersprofile->crops;
        $machineries = $farmersprofile->machineries;
        $provinces = Provinces::all();
        $municipalities = Municipalities::all();
        $barangays = Barangays::all();
        $commodities = Commodities::where('category', 0)->pluck('commodities', 'id')->all();
        $farmers = Commodities::where('category', 1)->pluck('commodities', 'id')->all();
        $machine = Machine::pluck('machine', 'id')->all();
        $others = Commodities::where('category', 3)->pluck('commodities', 'id')->all();

        return view('admin.farmers.update', compact(
            'others',
            'commodities',
            'highest_formal_education',
            'farmers',
            'machine',
            'farmersprofile',
            'crops',
            'machineries',
            'civilStatusOptions',
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
            'mname' => 'nullable',
            'ename' => 'nullable',
            'sex' => 'required',
            'spouse' => 'nullable',
            'number' => 'required',
            'mother' => 'required',
            'regions' => 'required',
            'provinces_id' => 'required',
            'municipalities_id' => 'required',
            'barangays_id' => 'required',
            'purok' => 'required',
            'house' => 'nullable',
            'dob' => 'required|date',
            'pob' => 'required',
            'religion' => 'required',
            // 'cstatus' => 'required',
            'civil_status_id' => 'required',
            'highest_formal_education_id' => 'required',
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
            // 'cstatus' => $request->input('cstatus'),
            'civil_status_id' => $request->input('civil_status_id'),
            'highest_formal_education_id' => $request->input('highest_formal_education_id'),
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
        $barangaysId = $request->input('barangays_id', null);

        // Delete existing records related to the current farmersprofile
        $farmersprofile->crops()->delete();

        if (empty($selectedCommodities)) {
            // If no commodities are selected, save null values
            $farmersprofile->crops()->create([
                'commodities_id' => null,
                'farm_size' => null,
                'farm_location' => null,
                'barangays_id' => $barangaysId,
            ]);
        } else {
            // If commodities are selected, loop through them and save the data
            foreach ($selectedCommodities as $id => $commodityId) {
                $farmersprofile->crops()->create([
                    'commodities_id' => $commodityId,
                    'farm_size' => $farmSizes[$commodityId],
                    'farm_location' => $farmLocations[$commodityId],
                    'barangays_id' => $barangaysId,
                ]);
            }
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

if ($farmersNumber && $farmersNumber->barangays_id !== $barangaysId) {
    // Find the last farmersnumber for the new barangays_id
    $lastFarmersNumber = FarmersNumber::where('barangays_id', $barangaysId)
        ->orderByRaw('SUBSTRING_INDEX(farmersnumber, " - ", -1) + 0 DESC') // Order by the numerical part of the farmersnumber in descending order
        ->first();

    // Extract the count and increment it
    $count = 1;
    if ($lastFarmersNumber) {
        $lastFarmersNumberParts = explode(' - ', $lastFarmersNumber->farmersnumber);
        $count = intval($lastFarmersNumberParts[1]) + 1;
    }

    // Construct the new farmersnumber
    $newFarmersNumber = "BLN {$barangaysId} - {$count}";

    // Update the farmersnumber
    $farmersNumber->farmersnumber = $newFarmersNumber;
    $farmersNumber->barangays_id = $barangaysId;
    $farmersNumber->save();
}





        activity()
            ->causedBy(auth()->user()) // Assuming you're logged in
            ->performedOn($farmersprofile) // The FarmersProfile being updated
            ->withProperties(['attributes' => $updatedAttributes]) // Include updated attributes
            ->log('Update Farmer Profile');

        // Update the FarmersProfile's attributes
        $farmersprofile->update($updatedAttributes);

        return redirect('farmreport')->with('message', 'Farmers Data Update Successfully!');
    }



    public function benefits($id)
    {
        $highest_formal_education = HighestFormalEducation::all();
        $civilStatusOptions = Status::all();
        $barangays = Barangays::all();
        $farmersprofile = FarmersProfile::findOrFail($id);
        $provinces = Provinces::all();
        $commodities = Commodities::where('category', 0)->pluck('commodities', 'id')->all();
        $farmers = Commodities::where('category', 1)->pluck('commodities', 'id')->all();
        $machine = Machine::pluck('machine', 'id')->all();

        return view('admin.farmers.benefits', compact('commodities', 'farmersprofile', 'civilStatusOptions', 'highest_formal_education', 'farmers', 'machine', 'provinces', 'barangays'));
    }
 // Import the FarmersProfile model

 public function beneficiary(Request $request, $id)
 {
    $farmersprofile = FarmersProfile::findorfail($id);
    $validator = Validator::make($request->all(), [
        'benefits' => 'required|array',
        'benefits.*' => 'required|string', // adjust this rule based on your actual data type
        'date' => 'required|array',
        'date.*' => 'required|date', // adjust this rule based on your actual data type
    ]);
    if ($validator->fails()) {
        return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
    }

    foreach ($request->input('benefits') as $key => $benefit) {
        $newBenefit = new Benefits([
            'benefits' => $benefit,
            'date' => $request->input('date')[$key],
            'farmersprofile_id' => $id,
        ]);
        $newBenefit->save();
    }

    //  dd($request->all());


     // If you want to redirect back after saving, you can use:
     return redirect('farmreport')->with('message', 'Form submitted successfully');
 }





}

