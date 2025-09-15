<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PropertyUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'city' => ['sometimes', 'string', 'max:120'],
            'rooms' => ['sometimes', 'integer', 'min:0', 'max:20'],
            'bathrooms' => ['sometimes', 'integer', 'min:0', 'max:20'],
            'consignation_type' => ['sometimes', Rule::in(['rent', 'sale', 'rent_sale'])],
            'rent_price' => ['sometimes','nullable', 'integer', 'min:0'],
            'sale_price' => ['sometimes','nullable', 'integer', 'min:0'],
            'has_pool' => ['sometimes', 'in:true,false,1,0,on,off'],
            'has_elevator' => ['sometimes', 'in:true,false,1,0,on,off'],
            'parking_type' => ['sometimes', Rule::in(['none', 'dos', 'comunal'])],
            'images' => ['sometimes', 'array', 'max:10'],
            'images.*' => ['file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'images_alt' => ['sometimes', 'array'],
            'images_alt.*' => ['nullable', 'string', 'max:120'],
        ];
    }
}
