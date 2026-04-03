@extends('layouts.workspace')

@section('content')
    <div class="workspace-content-stack">
        <section class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
            <div>
                <div class="text-sm text-slate-500">
                    {{ __('messages.nav_weekly_plans') }} / {{ $weeklyPlan->title }}
                </div>
                <h1 class="workspace-page-title mt-2">{{ __('messages.weekly_plan_planner') }}</h1>
                <p class="workspace-page-description">
                    {{ $weeklyPlan->week_start_date?->format('Y-m-d') }} / {{ __('messages.weekly_plans_description') }}
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <span class="badge rounded-full border-0 px-4 py-3 {{ $weeklyPlan->is_finalized ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                    {{ $weeklyPlan->is_finalized ? __('messages.yes') : __('messages.no') }}
                </span>
                <a href="{{ route('weekly-plans.index') }}" class="btn btn-outline rounded-full border-slate-200 px-5 normal-case text-slate-700 hover:border-slate-300 hover:bg-slate-50">
                    {{ __('messages.nav_weekly_plans') }}
                </a>
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1.75fr),320px]">
            <div class="space-y-6">
                <section class="workspace-field-shell">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.weekly_plan_basic_info') }}</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.weekly_plan_note') }}</p>
                        </div>
                    </div>

                    <form action="{{ route('weekly-plans.update', $weeklyPlan) }}" method="POST" class="mt-6 space-y-5">
                        @method('PUT')
                        @include('weekly-plans._form', ['weeklyPlan' => $weeklyPlan])
                    </form>
                </section>

                <section class="workspace-card">
                    <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.weekly_plan_planner') }}</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.weekly_plans_description') }}</p>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <span class="workspace-chip">{{ __('messages.weekly_summary_total_kcal') }}: {{ $summary['weekly_calories'] }}</span>
                            <span class="workspace-chip">{{ __('messages.weekly_summary_avg_daily') }}: {{ $summary['average_daily_calories'] }}</span>
                        </div>
                    </div>

                    <div class="planner-board mt-6">
                        <div class="planner-board-grid">
                            @foreach ($dayOptions as $dayNumber => $dayKey)
                                @php
                                    $dayItems = collect($slots[$dayNumber])->flatten(1);
                                    $dayCalories = round($dayItems->sum(fn ($item) => $item->calories()), 1);
                                    $plannedCount = $dayItems->count();
                                @endphp

                                <div class="planner-day-column">
                                    <div class="planner-day-header">
                                        <div class="text-sm font-semibold text-slate-900">{{ __('messages.day_' . $dayKey) }}</div>
                                        <div class="mt-3 flex items-end justify-between gap-3">
                                            <div>
                                                <div class="text-xs uppercase tracking-[0.16em] text-slate-400">Meals</div>
                                                <div class="mt-1 text-lg font-semibold text-slate-900">{{ $plannedCount }}</div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-xs uppercase tracking-[0.16em] text-slate-400">kcal</div>
                                                <div class="mt-1 text-lg font-semibold text-slate-900">{{ $dayCalories }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    @foreach ($mealTypeOptions as $mealType)
                                        <div class="planner-meal-card">
                                            <div class="flex items-center justify-between gap-2">
                                                <h3 class="text-sm font-semibold text-slate-900">{{ __('messages.meal_type_' . $mealType) }}</h3>
                                                <button
                                                    type="button"
                                                    class="btn btn-outline btn-xs rounded-full border-slate-200 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50"
                                                    onclick="document.getElementById('modal_{{ $dayNumber }}_{{ $mealType }}').showModal()"
                                                >
                                                    {{ __('messages.weekly_plan_add_food_button') }}
                                                </button>
                                            </div>

                                            <div class="mt-3 space-y-2">
                                                @forelse ($slots[$dayNumber][$mealType] as $item)
                                                    <div class="planner-food-card">
                                                        <div class="font-medium text-slate-900">{{ $item->food->displayName() }}</div>
                                                        <div class="mt-1 text-sm text-slate-600">{{ $item->amount_g }} g / {{ round($item->calories(), 1) }} kcal</div>

                                                        <form action="{{ route('weekly-plan-foods.destroy', $item) }}" method="POST" class="mt-3">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-error btn-xs rounded-full border-0 normal-case">
                                                                {{ __('messages.delete') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                @empty
                                                    <div class="planner-empty-slot">{{ __('messages.weekly_plan_slot_empty') }}</div>
                                                @endforelse
                                            </div>
                                        </div>

                                        <dialog id="modal_{{ $dayNumber }}_{{ $mealType }}" class="modal">
                                            <div class="modal-box rounded-3xl border border-slate-200 bg-white">
                                                <h3 class="text-lg font-semibold text-slate-900">{{ __('messages.weekly_plan_add_food') }}</h3>
                                                <p class="mt-1 text-sm text-slate-600">
                                                    {{ __('messages.day_' . $dayKey) }} / {{ __('messages.meal_type_' . $mealType) }}
                                                </p>

                                                <form action="{{ route('weekly-plan-foods.store', $weeklyPlan) }}" method="POST" class="mt-6 space-y-5">
                                                    @csrf
                                                    <input type="hidden" name="day_of_week" value="{{ $dayNumber }}">
                                                    <input type="hidden" name="meal_type" value="{{ $mealType }}">

                                                    <div>
                                                        <x-input-label for="food_search_{{ $dayNumber }}_{{ $mealType }}" :value="__('messages.food_name')" />
                                                        <x-text-input
                                                            type="text"
                                                            id="food_search_{{ $dayNumber }}_{{ $mealType }}"
                                                            placeholder="{{ __('messages.food_search_placeholder') }}"
                                                            autocomplete="off"
                                                            oninput="filterFoodOptions('{{ $dayNumber }}_{{ $mealType }}')"
                                                        />

                                                        <input type="hidden" name="food_id" id="food_id_{{ $dayNumber }}_{{ $mealType }}" value="">

                                                        <div id="food_selected_{{ $dayNumber }}_{{ $mealType }}" class="mt-3 text-sm text-slate-600">
                                                            {{ __('messages.food_no_selection') }}
                                                        </div>

                                                        <div id="food_results_{{ $dayNumber }}_{{ $mealType }}" class="mt-3 max-h-48 overflow-y-auto rounded-2xl border border-slate-200 bg-slate-50"></div>

                                                        @error('food_id')
                                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <x-input-label for="amount_g_{{ $dayNumber }}_{{ $mealType }}" :value="__('messages.weekly_plan_amount_g')" />
                                                        <x-text-input type="number" step="0.1" name="amount_g" id="amount_g_{{ $dayNumber }}_{{ $mealType }}" min="1" />
                                                    </div>

                                                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                                                        <button
                                                            type="button"
                                                            class="btn btn-outline rounded-full border-slate-200 px-5 normal-case text-slate-700 hover:border-slate-300 hover:bg-slate-50"
                                                            onclick="document.getElementById('modal_{{ $dayNumber }}_{{ $mealType }}').close()"
                                                        >
                                                            {{ __('messages.cancel') }}
                                                        </button>
                                                        <button type="submit" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
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
                </section>
            </div>

            <aside class="space-y-4 xl:sticky xl:top-8 xl:self-start">
                <div class="workspace-card">
                    <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.weekly_summary_title') }}</h2>
                    <div class="mt-5 space-y-4">
                        <div class="workspace-helper-card">
                            <div class="text-sm text-slate-500">{{ __('messages.weekly_summary_avg_vs_target') }}</div>
                            <div class="mt-3 flex items-end justify-between gap-3">
                                <div>
                                    <div class="text-3xl font-semibold text-slate-900">{{ $summary['average_daily_calories'] }}</div>
                                    <div class="mt-1 text-xs uppercase tracking-[0.16em] text-slate-400">{{ __('messages.weekly_summary_avg_daily') }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-semibold text-slate-900">{{ $summary['target_calories'] ?? '-' }}</div>
                                    <div class="mt-1 text-xs uppercase tracking-[0.16em] text-slate-400">{{ __('messages.weekly_summary_target') }}</div>
                                </div>
                            </div>
                            <p class="mt-3 text-sm text-emerald-700">
                                {{ __('messages.weekly_summary_difference') }}:
                                {{ $summary['avg_vs_target'] ?? '-' }}@if (! is_null($summary['avg_vs_target'])) kcal @endif
                            </p>
                        </div>

                        <div class="workspace-helper-card">
                            <div class="text-sm font-semibold text-slate-900">{{ __('messages.weekly_summary_macros_totals') }}</div>
                            <div class="mt-4 space-y-3 text-sm text-slate-600">
                                <div class="flex items-center justify-between"><span>{{ __('messages.plan_protein') }}</span><strong>{{ $summary['weekly_protein_g'] }} g</strong></div>
                                <div class="flex items-center justify-between"><span>{{ __('messages.plan_carbs') }}</span><strong>{{ $summary['weekly_carbs_g'] }} g</strong></div>
                                <div class="flex items-center justify-between"><span>{{ __('messages.plan_fat') }}</span><strong>{{ $summary['weekly_fat_g'] }} g</strong></div>
                            </div>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-1">
                            <div class="workspace-helper-card">
                                <div class="text-sm text-slate-500">{{ __('messages.weekly_summary_total_kcal') }}</div>
                                <div class="mt-2 text-2xl font-semibold text-slate-900">{{ $summary['weekly_calories'] }}</div>
                            </div>
                            <div class="workspace-helper-card">
                                <div class="text-sm text-slate-500">{{ __('messages.weekly_plan_planner') }}</div>
                                <div class="mt-2 text-2xl font-semibold text-slate-900">{{ $weeklyPlan->weeklyPlanFoods->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="workspace-card">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Week Overview</h3>
                    <div class="mt-4 space-y-3">
                        @foreach ($dayOptions as $dayNumber => $dayKey)
                            @php
                                $dayItems = collect($slots[$dayNumber])->flatten(1);
                            @endphp
                            <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm">
                                <span class="font-medium text-slate-900">{{ __('messages.day_' . $dayKey) }}</span>
                                <span class="text-slate-600">{{ $dayItems->count() }} items</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
        const foodPickerItems = @json($foodPickerItems);

        function filterFoodOptions(slotKey) {
            const searchInput = document.getElementById(`food_search_${slotKey}`);
            const keyword = searchInput.value.trim().toLowerCase();

            const filtered = foodPickerItems.filter(item => {
                return item.name.toLowerCase().includes(keyword)
                    || item.category.toLowerCase().includes(keyword);
            });

            renderFoodOptions(slotKey, filtered.slice(0, 20));
        }

        function renderFoodOptions(slotKey, items) {
            const resultsBox = document.getElementById(`food_results_${slotKey}`);
            resultsBox.innerHTML = '';

            if (items.length === 0) {
                resultsBox.innerHTML = `
                    <div class="p-3 text-sm text-slate-500">
                        {{ __('messages.food_no_results') }}
                    </div>
                `;
                return;
            }

            items.forEach(item => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'w-full border-b border-slate-200 px-3 py-3 text-left transition hover:bg-white last:border-b-0';

                button.innerHTML = `
                    <div class="font-medium text-slate-900">${escapeHtml(item.name)}</div>
                    <div class="mt-1 text-xs text-slate-500">${escapeHtml(item.category)}</div>
                `;

                button.addEventListener('click', () => {
                    selectFoodOption(slotKey, item.id, item.name, item.category);
                });

                resultsBox.appendChild(button);
            });
        }

        function selectFoodOption(slotKey, foodId, foodName, foodCategory) {
            document.getElementById(`food_id_${slotKey}`).value = foodId;
            document.getElementById(`food_search_${slotKey}`).value = foodName;
            document.getElementById(`food_selected_${slotKey}`).textContent =
                `{{ __('messages.food_selected_label') }}: ${foodName} (${foodCategory})`;

            document.getElementById(`food_results_${slotKey}`).innerHTML = '';
        }

        function escapeHtml(text) {
            return String(text)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }
    </script>
@endsection
