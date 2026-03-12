<?php

namespace App\Http\Requests;

use App\Models\Food;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null
            && $this->user()->role === 'admin'
            && $this->user()->is_active;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(Food::CATEGORY_OPTIONS)],
            'calories_per_100g' => ['required', 'numeric', 'min:0', 'max:9999.99'],
            'protein_per_100g' => ['required', 'numeric', 'min:0', 'max:100'],
            'carbs_per_100g' => ['required', 'numeric', 'min:0', 'max:100'],
            'fat_per_100g' => ['required', 'numeric', 'min:0', 'max:100'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'is_verified' => ['nullable', 'boolean'],
        ];
    }
}