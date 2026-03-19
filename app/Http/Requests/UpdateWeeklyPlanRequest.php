<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWeeklyPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'week_start_date' => ['required', 'date'],
            'note' => ['nullable', 'string', 'max:1000'],
            'is_finalized' => ['nullable', 'boolean'],
        ];
    }
}