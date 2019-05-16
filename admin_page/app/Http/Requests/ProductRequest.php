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
            'name' => 'required|string|max:64',
            'price' => 'required|integer|min:0',
            'wholesaler_price' => 'required|integer|min:0',
            'is_compounded' => 'required|boolean',
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
            'wholesaler_price' => Str::lower(__('navigation.products.wholesaler_price')),
            'is_compounded' => Str::lower(__('navigation.products.is_compounded')),
        ];
    }
}
