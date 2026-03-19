<?php

namespace App\Http\Requests;

use App\Models\Food;
use App\Models\WeeklyPlan;
use App\Models\WeeklyPlanFood;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWeeklyPlanFoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'food_id' => ['required', 'integer', Rule::exists((new Food())->getTable(), 'id')],
            'day_of_week' => ['required', 'integer', Rule::in(array_keys(WeeklyPlan::DAY_OPTIONS))],
            'meal_type' => ['required', Rule::in(WeeklyPlanFood::MEAL_TYPE_OPTIONS)],
            'amount_g' => ['required', 'numeric', 'min:1', 'max:5000'],
        ];
    }
}