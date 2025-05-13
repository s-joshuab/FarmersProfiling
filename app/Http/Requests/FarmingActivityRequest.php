<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FarmingActivityRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you need authorization
    }

    public function rules()
    {
        return [
            'farmers_id' => 'required|exists:farmers_profile,id',
            'commodities_id' => 'required|exists:commodities,id',
            'farm_size' => 'required|string',
            'farm_location' => 'required|string',
        ];
    }
}
