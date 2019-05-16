<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductFormatRequest extends FormRequest
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
            'added_price' => 'required|integer|min:0',
            'capacity' => 'nullable|integer|min:0',
            'minimum_quantity' => 'required|integer|min:0',
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
            'name' => Str::lower(__('navigation.formats.name')),
            'added_price' => Str::lower(__('navigation.formats.added_price')),
            'capacity' => Str::lower(__('navigation.formats.capacity')),
            'minimum_quantity' => Str::lower(__('navigation.formats.minimum_quantity')),
        ];
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        $all = parent::validationData();
        
        if($all['capacity'] === null) {
            $all['capacity'] = 0;
        }
        return $all;
    }
}
