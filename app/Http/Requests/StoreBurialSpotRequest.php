<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBurialSpotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'plot_number' => 'required|string|max:50|unique:burial_spots,plot_number,' . $this->burialSpot?->id,
            'section'     => 'nullable|string|max:100',
            'birth_year'  => 'nullable|integer|min:1800|max:' . date('Y'),
            'death_year'  => 'nullable|integer|min:1800|max:' . date('Y'),
            'status'      => 'required|in:occupied,reserved,available',
            'notes'       => 'nullable|string|max:500',
        ];
    }
}
