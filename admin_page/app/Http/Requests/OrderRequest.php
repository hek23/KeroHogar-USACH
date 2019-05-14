<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class OrderRequest extends FormRequest
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
            'product' => 'required|integer',
            'quantity' => 'required|integer',
            'delivery_status' => 'required|integer',
            'payment_status' => 'required|integer',
            'delivery_date' => 'required|date',
            'delivery_time' => 'required|array',
            'rut' => 'required|cl_rut',
            'name' => 'required|string|max:64',
            'town' => 'required|integer',
            'address' => 'required|string',
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
            'rut.cl_rut' => 'El rut ingresado no es válido',
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
            'product' => Str::lower(__('navigation.orders.product')),
            'amount' => Str::lower(__('navigation.orders.amount')),
            'quantity' => Str::lower(__('navigation.orders.quantity')),
            'delivery_status' => Str::lower(__('navigation.orders.delivery_status')),
            'payment_status' => Str::lower(__('navigation.orders.payment_status')),
            'delivery_date' => Str::lower(__('navigation.orders.delivery_date')),
            'delivery_time' => Str::lower(__('navigation.orders.delivery_time')),
            'rut' => Str::lower(__('navigation.orders.rut')),
            'name' => Str::lower(__('navigation.orders.name')),
            'town' => Str::lower(__('navigation.orders.town')),
            'address' => Str::lower(__('navigation.orders.address')),
        ];
    }
}
