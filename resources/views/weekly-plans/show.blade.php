@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold">{{ $weeklyPlan->title }}</h1>
                <p class="text-base-content/70">
                    {{ __('messages.weekly_plan_week_start_date') }}: {{ $weeklyPlan->week_start_date?->format('Y-m-d') }}
                </p>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[2fr_380px]">
            <div class="space-y-6">
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <h2 class="card-title">{{ __('messages.weekly_plan_basic_info') }}</h2>

                        <form action="{{ route('weekly-plans.update', $weeklyPlan) }}" method="POST" class="mt-4">
                            @method('PUT')
                            @include('weekly-plans._form', ['weeklyPlan' => $weeklyPlan])
                        </form>
                    </div>
                </div>

                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <h2 class="card-title">{{ __('messages.weekly_plan_planner') }}</h2>

                        <div class="grid gap-4 lg:grid-cols-7 mt-4">
                            @foreach ($dayOptions as $dayNumber => $dayKey)
                                <div class="space-y-3">
                                    <div class="rounded-box border bg-base-200 p-3 text-center">
                                        <div class="font-semibold">{{ __('messages.day_' . $dayKey) }}</div>
                                    </div>

                                    @foreach ($mealTypeOptions as $mealType)
                                        <div class="rounded-box border bg-base-100 p-3 space-y-3">
                                            <div class="flex items-center justify-between">
                                                <h3 class="font-semibold">
                                                    {{ __('messages.meal_type_' . $mealType) }}
                                                </h3>

                                                <button
                                                    type="button"
                                                    class="btn btn-xs btn-outline"
                                                    onclick="document.getElementById('modal_{{ $dayNumber }}_{{ $mealType }}').showModal()"
                                                >
                                                    {{ __('messages.weekly_plan_add_food_button') }}
                                                </button>
                                            </div>

                                            <div class="space-y-2">
                                                @forelse ($slots[$dayNumber][$mealType] as $item)
                                                    <div class="rounded-lg border border-base-300 p-2 text-sm">
                                                        <div class="font-medium">{{ $item->food->displayName() }}</div>
                                                        <div class="text-base-content/70">
                                                            {{ $item->amount_g }} g · {{ round($item->calories(), 1) }} kcal
                                                        </div>

                                                        <form action="{{ route('weekly-plan-foods.destroy', $item) }}" method="POST" class="mt-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-xs btn-error">
                                                                {{ __('messages.delete') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                @empty
                                                    <div class="rounded-lg border border-dashed border-base-300 p-3 text-sm text-base-content/60">
                                                        {{ __('messages.weekly_plan_slot_empty') }}
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>

                                        <dialog id="modal_{{ $dayNumber }}_{{ $mealType }}" class="modal">
                                            <div class="modal-box">
                                                <h3 class="text-lg font-bold">
                                                    {{ __('messages.weekly_plan_add_food') }}
                                                </h3>
                                                <p class="text-sm text-base-content/70 mt-1">
                                                    {{ __('messages.day_' . $dayKey) }} · {{ __('messages.meal_type_' . $mealType) }}
                                                </p>

                                                <form action="{{ route('weekly-plan-foods.store', $weeklyPlan) }}" method="POST" class="space-y-4 mt-4">
                                                    @csrf

                                                    <input type="hidden" name="day_of_week" value="{{ $dayNumber }}">
                                                    <input type="hidden" name="meal_type" value="{{ $mealType }}">

                                                    <div>
                                                        <label class="label" for="food_id_{{ $dayNumber }}_{{ $mealType }}">
                                                            <span class="label-text">{{ __('messages.food_name') }}</span>
                                                        </label>
                                                    
                                                        <select
                                                            name="food_id"
                                                            id="food_id_{{ $dayNumber }}_{{ $mealType }}"
                                                            class="select select-bordered w-full"
                                                        >
                                                            @foreach ($foods->groupBy('category') as $category => $groupedFoods)
                                                                <optgroup label="{{ __('messages.food_category_' . $category) }}">
                                                                    @foreach ($groupedFoods as $food)
                                                                        <option value="{{ $food->id }}">
                                                                            {{ $food->displayName() }}
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @endforeach
                                                        </select>
                                                    
                                                        @error('food_id')
                                                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label class="label" for="amount_g_{{ $dayNumber }}_{{ $mealType }}">
                                                            <span class="label-text">{{ __('messages.weekly_plan_amount_g') }}</span>
                                                        </label>
                                                        <input
                                                            type="number"
                                                            step="0.1"
                                                            name="amount_g"
                                                            id="amount_g_{{ $dayNumber }}_{{ $mealType }}"
                                                            class="input input-bordered w-full"
                                                            min="1"
                                                        >
                                                    </div>

                                                    <div class="modal-action">
                                                        <form method="dialog">
                                                            <button class="btn">
                                                                {{ __('messages.cancel') }}
                                                            </button>
                                                        </form>
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('messages.weekly_plan_add_food_button') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>

                                            <form method="dialog" class="modal-backdrop">
                                                <button>{{ __('messages.close') }}</button>
                                            </form>
                                        </dialog>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="card bg-base-100 shadow sticky top-4">
                    <div class="card-body space-y-4">
                        <h2 class="card-title">{{ __('messages.weekly_summary_title') }}</h2>

                        <div class="rounded-box border p-4">
                            <div class="text-sm text-base-content/70">{{ __('messages.weekly_summary_total_kcal') }}</div>
                            <div class="text-2xl font-bold">{{ $summary['weekly_calories'] }}</div>
                        </div>

                        <div class="rounded-box border p-4">
                            <div class="text-sm text-base-content/70">{{ __('messages.weekly_summary_avg_vs_target') }}</div>
                            <div class="text-sm mt-2">
                                {{ __('messages.weekly_summary_avg_daily') }}: {{ $summary['average_daily_calories'] }} kcal
                            </div>
                            <div class="text-sm">
                                {{ __('messages.weekly_summary_target') }}:
                                {{ $summary['target_calories'] ?? '-' }}
                                @if ($summary['target_calories'])
                                    kcal
                                @endif
                            </div>
                            <div class="text-sm font-medium mt-2">
                                {{ __('messages.weekly_summary_difference') }}:
                                {{ $summary['avg_vs_target'] ?? '-' }}
                                @if (! is_null($summary['avg_vs_target']))
                                    kcal
                                @endif
                            </div>
                        </div>

                        <div class="rounded-box border p-4">
                            <div class="text-sm text-base-content/70 mb-2">{{ __('messages.weekly_summary_macros_totals') }}</div>
                            <div class="space-y-2 text-sm">
                                <div>{{ __('messages.plan_protein') }}: {{ $summary['weekly_protein_g'] }} g</div>
                                <div>{{ __('messages.plan_carbs') }}: {{ $summary['weekly_carbs_g'] }} g</div>
                                <div>{{ __('messages.plan_fat') }}: {{ $summary['weekly_fat_g'] }} g</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection