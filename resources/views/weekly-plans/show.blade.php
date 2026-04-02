@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="surface-card overflow-hidden">
            <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-[1.1fr,0.9fr] lg:p-10">
                <div>
                    <p class="page-kicker">{{ __('messages.app_name') }}</p>
                    <h1 class="page-title mt-3">{{ $weeklyPlan->title }}</h1>
                    <p class="page-description mt-4">
                        {{ __('messages.weekly_plan_week_start_date') }}: {{ $weeklyPlan->week_start_date?->format('Y-m-d') }}
                    </p>
                </div>

                <div class="surface-card-soft p-6">
                    <div class="space-y-3">
                        <div class="text-sm font-semibold uppercase tracking-[0.2em] text-green-700">{{ __('messages.weekly_summary_title') }}</div>
                        <div class="text-4xl font-semibold tracking-tight text-slate-900">{{ $summary['weekly_calories'] }}</div>
                        <p class="text-sm leading-6 text-slate-600">{{ __('messages.weekly_summary_total_kcal') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,2fr),360px]">
            <div class="space-y-6">
                <section class="section-card">
                    <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.weekly_plan_basic_info') }}</h2>

                    <form action="{{ route('weekly-plans.update', $weeklyPlan) }}" method="POST" class="mt-6">
                        @method('PUT')
                        @include('weekly-plans._form', ['weeklyPlan' => $weeklyPlan])
                    </form>
                </section>

                <section class="section-card">
                    <div class="page-header">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.weekly_plan_planner') }}</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.weekly_plans_description') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 lg:grid-cols-7">
                        @foreach ($dayOptions as $dayNumber => $dayKey)
                            <div class="space-y-3">
                                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-3 text-center">
                                    <div class="text-sm font-semibold text-slate-900">{{ __('messages.day_' . $dayKey) }}</div>
                                </div>

                                @foreach ($mealTypeOptions as $mealType)
                                    <div class="rounded-3xl border border-slate-200 bg-white p-3 shadow-sm">
                                        <div class="flex items-center justify-between gap-2">
                                            <h3 class="text-sm font-semibold text-slate-900">
                                                {{ __('messages.meal_type_' . $mealType) }}
                                            </h3>

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
                                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm">
                                                    <div class="font-medium text-slate-900">{{ $item->food->displayName() }}</div>
                                                    <div class="mt-1 text-slate-600">
                                                        {{ $item->amount_g }} g · {{ round($item->calories(), 1) }} kcal
                                                    </div>

                                                    <form action="{{ route('weekly-plan-foods.destroy', $item) }}" method="POST" class="mt-3">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-error btn-xs rounded-full border-0 normal-case">
                                                            {{ __('messages.delete') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            @empty
                                                <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-4 text-sm text-slate-500">
                                                    {{ __('messages.weekly_plan_slot_empty') }}
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <dialog id="modal_{{ $dayNumber }}_{{ $mealType }}" class="modal">
                                        <div class="modal-box rounded-3xl border border-slate-200 bg-white">
                                            <h3 class="text-lg font-semibold text-slate-900">
                                                {{ __('messages.weekly_plan_add_food') }}
                                            </h3>
                                            <p class="mt-1 text-sm text-slate-600">
                                                {{ __('messages.day_' . $dayKey) }} · {{ __('messages.meal_type_' . $mealType) }}
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

                                                    <input
                                                        type="hidden"
                                                        name="food_id"
                                                        id="food_id_{{ $dayNumber }}_{{ $mealType }}"
                                                        value=""
                                                    >

                                                    <div
                                                        id="food_selected_{{ $dayNumber }}_{{ $mealType }}"
                                                        class="mt-3 text-sm text-slate-600"
                                                    >
                                                        {{ __('messages.food_no_selection') }}
                                                    </div>

                                                    <div
                                                        id="food_results_{{ $dayNumber }}_{{ $mealType }}"
                                                        class="mt-3 max-h-48 overflow-y-auto rounded-2xl border border-slate-200 bg-slate-50"
                                                    ></div>

                                                    @error('food_id')
                                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <x-input-label for="amount_g_{{ $dayNumber }}_{{ $mealType }}" :value="__('messages.weekly_plan_amount_g')" />
                                                    <x-text-input
                                                        type="number"
                                                        step="0.1"
                                                        name="amount_g"
                                                        id="amount_g_{{ $dayNumber }}_{{ $mealType }}"
                                                        min="1"
                                                    />
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
                </section>
            </div>

            <aside>
                <div class="section-card sticky top-24 space-y-4">
                    <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.weekly_summary_title') }}</h2>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-sm text-slate-500">{{ __('messages.weekly_summary_total_kcal') }}</div>
                        <div class="mt-2 text-2xl font-semibold text-slate-900">{{ $summary['weekly_calories'] }}</div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-sm text-slate-500">{{ __('messages.weekly_summary_avg_vs_target') }}</div>
                        <div class="mt-3 space-y-2 text-sm text-slate-700">
                            <div>{{ __('messages.weekly_summary_avg_daily') }}: <span class="font-medium text-slate-900">{{ $summary['average_daily_calories'] }} kcal</span></div>
                            <div>{{ __('messages.weekly_summary_target') }}:
                                <span class="font-medium text-slate-900">
                                    {{ $summary['target_calories'] ?? '-' }}@if ($summary['target_calories']) kcal @endif
                                </span>
                            </div>
                            <div>{{ __('messages.weekly_summary_difference') }}:
                                <span class="font-medium text-slate-900">
                                    {{ $summary['avg_vs_target'] ?? '-' }}@if (! is_null($summary['avg_vs_target'])) kcal @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="mb-3 text-sm text-slate-500">{{ __('messages.weekly_summary_macros_totals') }}</div>
                        <div class="space-y-2 text-sm text-slate-700">
                            <div>{{ __('messages.plan_protein') }}: <span class="font-medium text-slate-900">{{ $summary['weekly_protein_g'] }} g</span></div>
                            <div>{{ __('messages.plan_carbs') }}: <span class="font-medium text-slate-900">{{ $summary['weekly_carbs_g'] }} g</span></div>
                            <div>{{ __('messages.plan_fat') }}: <span class="font-medium text-slate-900">{{ $summary['weekly_fat_g'] }} g</span></div>
                        </div>
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
