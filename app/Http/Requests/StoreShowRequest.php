<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShowRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:1',
            'language' => 'nullable|string|max:50',
            'age_rating' => 'nullable|string|max:10',
            'venue_id' => 'required|exists:venues,id'
        ];
    }
}
