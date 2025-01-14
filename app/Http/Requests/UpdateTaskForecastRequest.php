<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskForecastRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'forecast_date' => 'required|date|date_format:Y-m-d',
            'planned_hours' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }

    public function messages(): array
    {
        return [
            'forecast_date.required' => 'The forecast date is required.',
            'forecast_date.date' => 'The forecast date must be a valid date.',
            'forecast_date.date_format' => 'The forecast date must be in the format YYYY-MM-DD.',
            'planned_hours.required' => 'The planned hours are required.',
            'planned_hours.numeric' => 'The planned hours must be a number.',
            'planned_hours.min' => 'The planned hours must be at least 0.',
            'planned_hours.regex' => 'The planned hours must be a numeric value with up to two decimal places.',
        ];
    }
}
