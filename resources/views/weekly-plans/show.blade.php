@extends('layouts.workspace')

@section('content')
    <div class="workspace-content-stack">
        <section class="workspace-page-header">
            <div>
                <div class="meta-text">
                    {{ __('messages.nav_weekly_plans') }} / {{ $weeklyPlan->title }}
                </div>
                <h1 class="workspace-page-title mt-2">{{ __('messages.weekly_plan_planner') }}</h1>
                <p class="workspace-page-description">
                    {{ $weeklyPlan->week_start_date?->format('Y-m-d') }} / {{ __('messages.weekly_plans_description') }}
                </p>
            </div>

            <div class="header-actions-tight">
                <span class="badge-ui {{ $weeklyPlan->is_finalized ? 'badge-ui-success' : 'badge-ui-warning' }}">
                    {{ $weeklyPlan->is_finalized ? __('messages.yes') : __('messages.no') }}
                </span>
                <a href="{{ route('weekly-plans.index') }}" class="btn-ui btn-ui-md btn-ui-secondary">
                    {{ __('messages.nav_weekly_plans') }}
                </a>
            </div>
        </section>

        <div class="ui-stack-md">
                <section class="workspace-card">
                    <div class="section-header-end">
                        <div>
                            <h2 class="form-section-heading">{{ __('messages.weekly_plan_planner') }}</h2>
                            <p class="form-section-description">{{ __('messages.weekly_plans_description') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 xl:grid-cols-[minmax(0,1.35fr),320px]">
                        <div class="workspace-helper-card avg-target-card">
                            <div class="meta-text">{{ __('messages.weekly_summary_avg_vs_target') }}</div>
                            <div class="mt-5 flex items-end justify-between gap-6">
                                <div class="min-w-0">
                                    <div class="text-5xl font-semibold tracking-tight text-slate-900">{{ $plannerSummary['average_daily_calories'] }}</div>
                                    <div class="tiny-label mt-2">{{ __('messages.weekly_summary_avg_daily') }}</div>
                                </div>
                                <div class="min-w-0 text-right">
                                    <div class="text-4xl font-semibold tracking-tight text-slate-900">{{ $plannerSummary['target_calories'] ?? '-' }}</div>
                                    <div class="tiny-label mt-2">{{ __('messages.weekly_summary_target') }}</div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <div class="h-3 overflow-hidden rounded-full bg-slate-200">
                                    <div
                                        class="h-3 rounded-full {{ ! is_null($plannerSummary['avg_vs_target']) && $plannerSummary['avg_vs_target'] > 0 ? 'bg-red-500' : 'bg-emerald-500' }}"
                                        style="width: {{ $plannerSummary['avg_progress_percent'] }}%"
                                    ></div>
                                </div>
                                <div class="info-row mt-3">
                                    <div class="rounded-2xl bg-white/80 px-4 py-3 shadow-sm">
                                        <div class="tiny-label">{{ __('messages.weekly_summary_difference') }}</div>
                                        <div class="mt-1 text-2xl font-semibold {{ ! is_null($plannerSummary['avg_vs_target']) && $plannerSummary['avg_vs_target'] > 0 ? 'text-red-600' : 'text-emerald-700' }}">
                                            {{ $plannerSummary['avg_vs_target'] ?? '-' }}@if (! is_null($plannerSummary['avg_vs_target'])) kcal @endif
                                        </div>
                                    </div>
                                    <div class="text-right meta-text">
                                        <div>{{ $plannerSummary['avg_progress_percent'] }}%</div>
                                        <div class="mt-1">{{ __('messages.weekly_summary_target') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-1">
                            <div class="workspace-helper-card">
                                <div class="mini-heading">{{ __('messages.weekly_summary_macros_totals') }}</div>
                                <div class="mt-3 space-y-3">
                                    <div class="macro-progress-card">
                                        <div class="flex items-start gap-3">
                                            <div class="macro-progress-icon macro-progress-icon-protein">🥩</div>
                                            <div class="min-w-0 flex-1">
                                                <div class="info-row">
                                                    <span class="text-sm font-semibold text-slate-900">{{ __('messages.plan_protein') }}</span>
                                                    <strong class="text-sm text-slate-900">{{ $plannerSummary['weekly_protein_g'] }} g</strong>
                                                </div>
                                                <div class="macro-progress-track mt-2">
                                                    <div class="macro-progress-fill macro-progress-fill-protein" style="width: {{ $plannerSummary['protein_progress_percent'] }}%"></div>
                                                </div>
                                                <div class="meta-text-xs mt-2">
                                                    @if (! is_null($plannerSummary['target_weekly_protein_g']))
                                                        {{ $plannerSummary['weekly_protein_g'] }} / {{ $plannerSummary['target_weekly_protein_g'] }} g {{ __('messages.weekly_summary_of_weekly_target') }}
                                                    @else
                                                        {{ __('messages.weekly_summary_no_macro_target') }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="macro-progress-card">
                                        <div class="flex items-start gap-3">
                                            <div class="macro-progress-icon macro-progress-icon-carbs">🌾</div>
                                            <div class="min-w-0 flex-1">
                                                <div class="info-row">
                                                    <span class="text-sm font-semibold text-slate-900">{{ __('messages.plan_carbs') }}</span>
                                                    <strong class="text-sm text-slate-900">{{ $plannerSummary['weekly_carbs_g'] }} g</strong>
                                                </div>
                                                <div class="macro-progress-track mt-2">
                                                    <div class="macro-progress-fill macro-progress-fill-carbs" style="width: {{ $plannerSummary['carbs_progress_percent'] }}%"></div>
                                                </div>
                                                <div class="meta-text-xs mt-2">
                                                    @if (! is_null($plannerSummary['target_weekly_carbs_g']))
                                                        {{ $plannerSummary['weekly_carbs_g'] }} / {{ $plannerSummary['target_weekly_carbs_g'] }} g {{ __('messages.weekly_summary_of_weekly_target') }}
                                                    @else
                                                        {{ __('messages.weekly_summary_no_macro_target') }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="macro-progress-card">
                                        <div class="flex items-start gap-3">
                                            <div class="macro-progress-icon macro-progress-icon-fat">💧</div>
                                            <div class="min-w-0 flex-1">
                                                <div class="info-row">
                                                    <span class="text-sm font-semibold text-slate-900">{{ __('messages.plan_fat') }}</span>
                                                    <strong class="text-sm text-slate-900">{{ $plannerSummary['weekly_fat_g'] }} g</strong>
                                                </div>
                                                <div class="macro-progress-track mt-2">
                                                    <div class="macro-progress-fill macro-progress-fill-fat" style="width: {{ $plannerSummary['fat_progress_percent'] }}%"></div>
                                                </div>
                                                <div class="meta-text-xs mt-2">
                                                    @if (! is_null($plannerSummary['target_weekly_fat_g']))
                                                        {{ $plannerSummary['weekly_fat_g'] }} / {{ $plannerSummary['target_weekly_fat_g'] }} g {{ __('messages.weekly_summary_of_weekly_target') }}
                                                    @else
                                                        {{ __('messages.weekly_summary_no_macro_target') }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h3 class="tiny-label text-slate-500">{{ __('messages.weekly_plan_week_overview') }}</h3>
                    </div>

                    <div class="planner-board mt-6">
                        <div class="planner-surface">
                            <div class="planner-summary-grid">
                                @foreach ($plannerDays as $plannerDay)
                                    <div class="planner-summary-card">
                                        <div class="text-sm font-semibold text-slate-900">{{ __('messages.day_' . $plannerDay['day_key']) }}</div>
                                        <div class="meta-text-xs mt-2">{{ __('messages.weekly_plan_meals_label') }}</div>
                                        <div class="mt-1 text-2xl font-semibold text-slate-900">{{ $plannerDay['item_count'] }}</div>
                                        <div class="meta-text-xs mt-3">kcal</div>
                                        <div class="mt-1 text-lg font-semibold text-slate-900">{{ $plannerDay['day_calories'] }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="planner-rows mt-4">
                                @foreach ($mealTypeOptions as $mealType)
                                    <div class="planner-row">
                                        <div class="planner-row-grid">
                                            @foreach ($plannerDays as $plannerDay)
                                                <div id="slot-{{ $plannerDay['day_number'] }}-{{ $mealType }}" class="planner-slot-card">
                                                    <div class="flex items-center justify-between gap-2">
                                                        <h3 class="flex items-center gap-1.5 text-sm font-semibold text-slate-900">
                                                            <span aria-hidden="true">{{ __('messages.meal_type_' . $mealType . '_emoji') }}</span>
                                                            <span>{{ __('messages.meal_type_' . $mealType) }}</span>
                                                        </h3>
                                                    </div>

                                                    <div class="mt-3 space-y-2">
                                                        @forelse ($plannerDay['meals'][$mealType] as $item)
                                                            <div class="planner-food-card">
                                                                <div class="planner-food-name">{{ $item->food->displayName() }}</div>
                                                                <div class="planner-food-meta">{{ $item->amount_g }} g / {{ round($item->calories(), 1) }} kcal</div>

                                                                <form action="{{ route('weekly-plan-foods.destroy', $item) }}" method="POST" class="mt-2">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="planner-food-delete-button">
                                                                        {{ __('messages.delete') }}
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @empty
                                                            <div class="planner-empty-slot">{{ __('messages.weekly_plan_slot_empty') }}</div>
                                                        @endforelse
                                                    </div>

                                                    <button
                                                        type="button"
                                                        class="planner-add-button mt-3"
                                                        onclick="openFoodPicker('{{ $plannerDay['day_number'] }}_{{ $mealType }}', 'modal_{{ $plannerDay['day_number'] }}_{{ $mealType }}')"
                                                    >
                                                        + {{ __('messages.weekly_plan_add_food_button') }}
                                                    </button>
                                                </div>

                                                <dialog id="modal_{{ $plannerDay['day_number'] }}_{{ $mealType }}" class="modal">
                                                    <div class="modal-box rounded-3xl border border-slate-200 bg-white">
                                                        <h3 class="text-lg font-semibold text-slate-900">{{ __('messages.weekly_plan_add_food') }}</h3>
                                                        <p class="mt-1 text-sm text-slate-600">
                                                            {{ __('messages.day_' . $plannerDay['day_key']) }} / {{ __('messages.meal_type_' . $mealType) }}
                                                        </p>

                                                        <form action="{{ route('weekly-plan-foods.store', $weeklyPlan) }}" method="POST" class="mt-6 space-y-5">
                                                            @csrf
                                                                <input type="hidden" name="day_of_week" value="{{ $plannerDay['day_number'] }}">
                                                                <input type="hidden" name="meal_type" value="{{ $mealType }}">
                                                                <input type="hidden" name="return_anchor" value="slot-{{ $plannerDay['day_number'] }}-{{ $mealType }}">

                                                                <div>
                                                                    <x-input-label for="food_search_{{ $plannerDay['day_number'] }}_{{ $mealType }}" :value="__('messages.food_name')" />
                                                                <x-text-input
                                                                    type="text"
                                                                    id="food_search_{{ $plannerDay['day_number'] }}_{{ $mealType }}"
                                                                    placeholder="{{ __('messages.food_search_placeholder') }}"
                                                                    autocomplete="off"
                                                                    onfocus="filterFoodOptions('{{ $plannerDay['day_number'] }}_{{ $mealType }}')"
                                                                    oninput="filterFoodOptions('{{ $plannerDay['day_number'] }}_{{ $mealType }}')"
                                                                />

                                                                <input type="hidden" name="food_id" id="food_id_{{ $plannerDay['day_number'] }}_{{ $mealType }}" value="">

                                                                <div id="food_selected_{{ $plannerDay['day_number'] }}_{{ $mealType }}" class="mt-3 text-sm text-slate-600">
                                                                    {{ __('messages.food_no_selection') }}
                                                                </div>

                                                                <div id="food_results_{{ $plannerDay['day_number'] }}_{{ $mealType }}" class="mt-3 max-h-48 overflow-y-auto rounded-2xl border border-slate-200 bg-slate-50"></div>

                                                                @error('food_id')
                                                                    <p class="form-error">{{ $message }}</p>
                                                                @enderror
                                                            </div>

                                                            <div>
                                                                <x-input-label for="amount_g_{{ $plannerDay['day_number'] }}_{{ $mealType }}" :value="__('messages.weekly_plan_amount_g')" />
                                                                <x-text-input type="number" step="0.1" name="amount_g" id="amount_g_{{ $plannerDay['day_number'] }}_{{ $mealType }}" min="1" />
                                                            </div>

                                                            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                                                                <button
                                                                    type="button"
                                                                    class="btn-ui btn-ui-md btn-ui-secondary"
                                                                    onclick="document.getElementById('modal_{{ $plannerDay['day_number'] }}_{{ $mealType }}').close()"
                                                                >
                                                                    {{ __('messages.cancel') }}
                                                                </button>
                                                                <button type="submit" class="btn-ui btn-ui-md btn-ui-primary">
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
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                <section class="workspace-field-shell">
                    <div class="workspace-page-header">
                        <div>
                            <h2 class="form-section-heading">{{ __('messages.weekly_plan_basic_info') }}</h2>
                        </div>
                    </div>

                    <form id="weekly-plan-update-form" action="{{ route('weekly-plans.update', $weeklyPlan) }}" method="POST" class="mt-6 space-y-5">
                        @method('PUT')
                        @include('weekly-plans._form', ['weeklyPlan' => $weeklyPlan])
                    </form>

                    <div class="form-actions mt-4 w-full justify-between">
                        <button
                            type="submit"
                            form="weekly-plan-update-form"
                            class="btn-ui btn-ui-md btn-ui-primary shrink-0"
                        >
                            {{ __('messages.save') }}
                        </button>

                        <form action="{{ route('weekly-plans.destroy', $weeklyPlan) }}" method="POST" class="inline-flex shrink-0">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="btn-ui btn-ui-md btn-ui-danger"
                            >
                                {{ __('messages.delete') }}
                            </button>
                        </form>
                    </div>
                </section>
        </div>
    </div>

    <script>
        const foodPickerOptions = @json($foodPickerOptions);
        const defaultFoodPickerCount = 12;

        function openFoodPicker(slotKey, modalId) {
            document.getElementById(modalId).showModal();
            filterFoodOptions(slotKey);
        }

        function filterFoodOptions(slotKey) {
            const searchInput = document.getElementById(`food_search_${slotKey}`);
            const keyword = searchInput.value.trim().toLowerCase();

            if (keyword === '') {
                renderFoodOptions(slotKey, foodPickerOptions.slice(0, defaultFoodPickerCount));
                return;
            }

            const filtered = foodPickerOptions.filter(item => {
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
