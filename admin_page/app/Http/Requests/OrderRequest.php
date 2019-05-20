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
            'product' => 'required|integer|min:1',
            'format' => 'nullable|integer|min:1',
            'quantity' => 'required|integer|min:0',
            'delivery_status' => 'required|integer',
            'payment_status' => 'required|integer',
            'delivery_date' => 'required|date',
            'delivery_time' => 'required|array',
            'rut' => 'nullable|cl_rut',
            'name' => 'required|string|max:64',
            'email' => 'nullable|string|email|max:64',
            'phone' => 'nullable|string|max:32',
            'wholesaler' => 'required|boolean',
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
            'format' => Str::lower(__('navigation.orders.format')),
            'amount' => Str::lower(__('navigation.orders.amount')),
            'quantity' => Str::lower(__('navigation.orders.quantity')),
            'delivery_status' => Str::lower(__('navigation.orders.delivery_status')),
            'payment_status' => Str::lower(__('navigation.orders.payment_status')),
            'delivery_date' => Str::lower(__('navigation.orders.delivery_date')),
            'delivery_time' => Str::lower(__('navigation.orders.delivery_time')),
            'rut' => Str::lower(__('navigation.orders.rut')),
            'name' => Str::lower(__('navigation.orders.name')),
            'email' => Str::lower(__('navigation.orders.email')),
            'phone' => Str::lower(__('navigation.orders.phone')),
            'wholesaler' => Str::lower(__('navigation.orders.wholesaler')),
            'town' => Str::lower(__('navigation.orders.town')),
            'address' => Str::lower(__('navigation.orders.address')),
        ];
    }
}
