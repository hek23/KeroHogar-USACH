<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            'client_type' => 'nullable|integer',
            'time_interval_start' => 'nullable|date',
            'time_interval_end' => 'nullable|date',
            'town_id' => 'nullable|integer',
            'order_status' => 'nullable|integer',
            'generate_excel' => 'nullable|bool',
        ];
    }
}
