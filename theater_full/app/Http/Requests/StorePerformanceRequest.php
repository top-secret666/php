<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePerformanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'show_id' => 'required|exists:shows,id',
            'venue_id' => 'nullable|exists:venues,id',
            'performance_date' => 'nullable|date',
            'performance_time' => 'nullable|date_format:H:i:s',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'notes' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
            'status' => 'nullable|string',
            'seats_map_version' => 'nullable|string',
        ];
    }
}
