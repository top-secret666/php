<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePerformanceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'show_id' => 'required|exists:shows,id',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after:starts_at',
            'status' => 'nullable|in:scheduled,cancelled,completed',
            'notes' => 'nullable|string'
        ];
    }
}
