<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PropertyStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'city' => ['required', 'string', 'max:120'],
            'rooms' => ['required', 'integer', 'min:0', 'max:20'],
            'bathrooms' => ['required', 'integer', 'min:0', 'max:20'],
            'consignation_type' => ['required', Rule::in(['rent', 'sale', 'rent_sale'])],

            // Precios: requeridos condicionalmente
            'rent_price' => ['nullable', 'integer', 'min:0', 'required_if:consignation_type,rent,rent_sale'],
            'sale_price' => ['nullable', 'integer', 'min:0', 'required_if:consignation_type,sale,rent_sale'],

            // Amenities opcionales
            'has_pool' => ['sometimes', 'in:true,false,1,0,on,off'],
            'has_elevator' => ['sometimes', 'in:true,false,1,0,on,off'],
            'parking_type' => ['sometimes', Rule::in(['none', 'dos', 'comunal'])],

            // Imágenes (opcional, múltiples)
            'images' => ['sometimes', 'array', 'max:10'],
            'images.*' => ['file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'], // 4MB c/u
            'images_alt' => ['sometimes', 'array'],
            'images_alt.*' => ['nullable', 'string', 'max:120'],
        ];
    }
}
