<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'birth_date' => 'nullable|date',

            // "роль + спектакль" requirement is stored in actor_show pivot
            'show_id' => 'nullable|integer|exists:shows,id',
            'character_name' => 'nullable|string|max:150',
            'billing_order' => 'nullable|integer|min:0',
        ];
    }
}
