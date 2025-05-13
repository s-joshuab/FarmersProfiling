<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FarmersProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you need authorization
    }

    public function rules()
    {
        return [
            'farmers_number' => 'required|unique:farmers_profile,farmers_number,' . ($this->id ?: 'NULL') . ',id',
            'reference_control_no' => 'required|unique:farmers_profile,reference_control_no,' . ($this->id ?: 'NULL') . ',id',
            'status' => 'required',
            's_name' => 'required',
            'f_name' => 'required',
            'm_name' => 'required',
            'sex' => 'required',
            'contact_number' => 'required|numeric',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required',
            'religion' => 'required',
            'civil_status' => 'required',
            'highest_formal_educational' => 'required',
            'PWD' => 'required|boolean',
            'benefits' => 'required|boolean',
            'main_livelihood' => 'required',
            'farm_location' => 'required',
            'farming_and_nonfarming' => 'required',
            'parcels' => 'required',
            'ARB' => 'required|boolean',
            'province_id' => 'required|exists:provinces,id',
            'municipality_id' => 'required|exists:municipalities,id',
            'barangay_id' => 'required|exists:barangays,id',
        ];
    }

    public function getValidationRules()
    {
        return $this->rules();
    }
}
