<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBodyMetricRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'recorded_on' => ['required', 'date', 'before_or_equal:today'],
            'weight_kg' => [
                'required',
                'numeric',
                'min:20',
                'max:300',
                'regex:/^\d{1,3}(\.\d)?$/',
            ],
            'body_fat_percentage' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
                'regex:/^\d{1,3}(\.\d)?$/',
            ],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }
}