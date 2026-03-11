<?php

namespace App\Http\Requests;

use App\Models\Profile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMyProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'sex' => ['required', Rule::in(Profile::SEX_OPTIONS)],
            'birth_date' => ['required', 'date', 'before:today'],

            'height_cm' => [
                'required',
                'numeric',
                'min:50',
                'max:250',
                'regex:/^\d{1,3}(\.\d)?$/',
            ],

            'current_weight_kg' => [
                'required',
                'numeric',
                'min:20',
                'max:300',
                'regex:/^\d{1,3}(\.\d)?$/',
            ],

            'activity_level' => ['required', Rule::in(Profile::ACTIVITY_LEVEL_OPTIONS)],
            'goal' => ['required', Rule::in(Profile::GOAL_OPTIONS)],
            'intensity' => ['required', Rule::in(Profile::INTENSITY_OPTIONS)],
        ];
    }
}