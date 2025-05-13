<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MachineriesRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you need authorization
    }

    public function rules()
    {
        return [
            'farmers_id' => 'required|exists:farmers_profile,id',
            'machine_id' => 'required|exists:machines,id',
            'no_of_units' => 'required|integer|min:1',
        ];
    }
}
