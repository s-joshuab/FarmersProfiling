<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangayRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you need authorization
    }

    public function rules()
    {
        return [
            'municipality_id' => 'required|exists:municipality,id',
            'barangay_name' => 'required|string',
        ];
    }
}

