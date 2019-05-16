<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class TimeBlockRequest extends FormRequest
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
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i|after:start',
            'max_orders' => 'integer|min:1',
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
            'start' => Str::lower(__('navigation.schedule.start')),
            'end' => Str::lower(__('navigation.schedule.end')),
            'max_orders' => Str::lower(__('navigation.schedule.max_orders')),
        ];
    }
}
