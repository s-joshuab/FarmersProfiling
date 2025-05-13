<?php

namespace App\Http\Livewire\Admin;

use App\Models\Barangay;
use App\Models\Commodiies;
use App\Models\Province;
use App\Models\Municipality;
use Livewire\Component as Components;

class FarmersData extends Components
{
    public $highValueCrops = false;

    public $selectedProvince;
    public $selectedMunicipality;
    public $selectedBarangay;
    public $municipalities = []; // Initialize as an empty array
    public $barangays = []; // Initialize as an empty array

    public function updatedSelectedProvince($provinceId)
    {
        $this->municipalities = Municipality::where('province_id', $provinceId)->get();
        $this->selectedMunicipality = null;
        $this->selectedBarangay = null;
        $this->barangays = [];
    }

    public function updatedSelectedMunicipality($municipalityId)
    {
        $this->barangays = Barangay::where('municipality_id', $municipalityId)->get();
        $this->selectedBarangay = null;
    }

    // More methods and logic can be added here...

}
