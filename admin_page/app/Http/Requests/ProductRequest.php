<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductRequest extends FormRequest
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
            'name' => 'required|string',
            'price' => 'required|integer',
            'minimum_amount' => 'required|integer',
            'unit' => 'required|string',
            'plural' => 'required|string',
            'liters_per_unit' => 'required|integer',
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
            'name' => Str::lower(__('navigation.products.name')),
            'price' => Str::lower(__('navigation.products.price')),
            'minimum_amount' => Str::lower(__('navigation.products.minimum_amount')),
            'unit' => Str::lower(__('navigation.products.unit')),
            'plural' => Str::lower(__('navigation.products.plural')),
            'liters_per_unit' => Str::lower(__('navigation.products.liters_per_unit')),
        ];
    }
}
