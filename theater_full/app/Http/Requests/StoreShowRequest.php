<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        // authorization handled elsewhere (middleware/policies); allow for now
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'director' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
            'language' => 'nullable|string|max:10',
            'age_rating' => 'nullable|string|max:10',
            'venue_id' => 'nullable|integer|exists:venues,id',
        ];
    }
}
