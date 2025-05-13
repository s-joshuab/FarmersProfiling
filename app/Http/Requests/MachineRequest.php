<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MachineRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you need authorization
    }

    public function rules()
    {
        return [
            'machine' => 'required|array',
            'machine.*' => 'exists:machine,id', // Validate each selected machine ID exists in the 'machine' table
        ];
    }
}

