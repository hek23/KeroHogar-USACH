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
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'discount_per_liter' => 'required|integer|min:0',
            'min_quantity' => 'required|integer|min:0',
            'max_quantity' => 'required|integer|gte:min_quantity|min:0',
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
            'max_quantity.gte' => 'La cantidad máxima debe ser mayor que la cantidad mínima',
            '*.min' => 'El campo :attribute debe ser positivo',
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
