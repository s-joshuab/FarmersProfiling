<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QrCodeRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you need authorization
    }

    public function rules()
    {
        return [
            'farmers_id' => 'required|exists:farmers_profile,id',
            'qr_image' => 'required|image|mimes:png,jpg,jpeg|max:2048', // Adjust the image validation rules as needed
        ];
    }
}
