<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommoditiesRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you need authorization
    }

    public function rules()
    {
        return [
            'commodities' => 'required|array',
            'commodities.*' => 'string',
        ];
    }
}
