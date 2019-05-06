<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductDiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'discount_per_liter' => 'required|integer',
            'min_quantity' => 'required|integer',
            'max_quantity' => 'required|integer|gt:min_quantity',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'max_quantity.gt' => 'La cantidad máxima debe ser mayor que la cantidad mínima',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'discount_per_liter' => Str::lower(__('navigation.discounts.discount_per_liter')),
            'min_quantity' => Str::lower(__('navigation.discounts.min_quantity')),
            'max_quantity' => Str::lower(__('navigation.discounts.max_quantity')),
        ];
    }
}
