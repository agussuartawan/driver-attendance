<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'category' => 'required|in:half_day,check_in_check_out,full_day',
            'start_location' => 'required|string|max:255',
            'start_latitude' => 'required|numeric',
            'start_longitude' => 'required|numeric',
            'end_location' => 'required|string|max:255',
            'end_latitude' => 'required|numeric',
            'end_longitude' => 'required|numeric',
            'driver_id' => 'required|exists:users,id',
        ];
    }
}
