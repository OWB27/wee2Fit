@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="public-hero">
            <div class="public-hero-grid !grid-cols-1">
                <div class="space-y-4">
                    <p class="page-kicker">{{ __('messages.app_name') }}</p>
                    <h1 class="page-title mt-5">{{ __('messages.methodology_page_title') }}</h1>
                    <p class="page-description mt-4">{{ __('messages.methodology_page_intro') }}</p>
                </div>
            </div>
        </section>

        <section class="space-y-5">
            <article class="public-section-card">
                <div class="flex items-start gap-4">
                    <div class="public-icon-badge">1</div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xl font-semibold tracking-tight text-slate-900">{{ __('messages.methodology_bmr_title') }}</h2>
                        <p class="descriptor-text">{{ __('messages.plan_bmr') }}</p>
                        <p class="mt-5 text-sm leading-7 text-slate-600">{{ __('messages.methodology_bmr_intro') }}</p>

                        <div class="mt-5 rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                                {{ __('messages.methodology_formula_label') }}
                            </div>
                            <div class="mt-4 space-y-3 text-sm text-slate-700">
                                <div class="rounded-2xl bg-white px-4 py-3 shadow-sm">
                                    <span class="mr-3 inline-flex rounded-full bg-sky-50 px-2 py-1 text-xs font-semibold text-sky-700">{{ __('messages.sex_male') }}</span>
                                    <span>BMR = (10 x weight_kg) + (6.25 x height_cm) - (5 x age) + 5</span>
                                </div>
                                <div class="rounded-2xl bg-white px-4 py-3 shadow-sm">
                                    <span class="mr-3 inline-flex rounded-full bg-rose-50 px-2 py-1 text-xs font-semibold text-rose-700">{{ __('messages.sex_female') }}</span>
                                    <span>BMR = (10 x weight_kg) + (6.25 x height_cm) - (5 x age) - 161</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <article class="public-section-card">
                <div class="flex items-start gap-4">
                    <div class="public-icon-badge bg-sky-100 text-sky-700">2</div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xl font-semibold tracking-tight text-slate-900">{{ __('messages.methodology_tdee_title') }}</h2>
                        <p class="descriptor-text">{{ __('messages.plan_tdee') }}</p>
                        <p class="mt-5 text-sm leading-7 text-slate-600">{{ __('messages.methodology_tdee_intro') }}</p>

                        <div class="mt-5 rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                                {{ __('messages.methodology_formula_label') }}
                            </div>
                            <div class="mt-4 rounded-2xl bg-white px-4 py-3 text-sm text-slate-700 shadow-sm">
                                TDEE = BMR x Activity Factor
                            </div>
                        </div>

                        <div class="mt-5 overflow-hidden rounded-3xl border border-slate-200">
                            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                                <thead class="bg-slate-50 text-slate-500">
                                    <tr>
                                        <th class="px-4 py-3 font-medium">{{ __('messages.profile_activity_level') }}</th>
                                        <th class="px-4 py-3 font-medium">{{ __('messages.methodology_factor_label') }}</th>
                                        <th class="px-4 py-3 font-medium">{{ __('messages.methodology_description_label') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                                    <tr>
                                        <td class="px-4 py-3">{{ __('messages.activity_sedentary') }}</td>
                                        <td class="px-4 py-3">1.2</td>
                                        <td class="px-4 py-3">{{ __('messages.methodology_activity_sedentary_desc') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">{{ __('messages.activity_light') }}</td>
                                        <td class="px-4 py-3">1.375</td>
                                        <td class="px-4 py-3">{{ __('messages.methodology_activity_light_desc') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">{{ __('messages.activity_moderate') }}</td>
                                        <td class="px-4 py-3">1.55</td>
                                        <td class="px-4 py-3">{{ __('messages.methodology_activity_moderate_desc') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">{{ __('messages.activity_active') }}</td>
                                        <td class="px-4 py-3">1.725</td>
                                        <td class="px-4 py-3">{{ __('messages.methodology_activity_active_desc') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">{{ __('messages.activity_very_active') }}</td>
                                        <td class="px-4 py-3">1.9</td>
                                        <td class="px-4 py-3">{{ __('messages.methodology_activity_very_active_desc') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </article>

            <article class="public-section-card">
                <div class="flex items-start gap-4">
                    <div class="public-icon-badge bg-lime-100 text-lime-700">3</div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xl font-semibold tracking-tight text-slate-900">{{ __('messages.methodology_goals_title') }}</h2>
                        <p class="descriptor-text">{{ __('messages.profile_goal') }} / {{ __('messages.profile_intensity') }}</p>
                        <p class="mt-5 text-sm leading-7 text-slate-600">{{ __('messages.methodology_goals_intro') }}</p>

                        <div class="mt-5 grid gap-4 lg:grid-cols-2">
                            <div class="rounded-3xl border bg-sky-50 p-5 text-sky-700 border-sky-100">
                                <h3 class="text-lg font-semibold">{{ __('messages.goal_cut') }}</h3>
                                <p class="mt-3 text-sm leading-6">{{ __('messages.methodology_goal_cut_summary') }}</p>
                            </div>

                            <div class="rounded-3xl border bg-emerald-50 p-5 text-emerald-700 border-emerald-100">
                                <h3 class="text-lg font-semibold">{{ __('messages.goal_bulk') }}</h3>
                                <p class="mt-3 text-sm leading-6">{{ __('messages.methodology_goal_bulk_summary') }}</p>
                            </div>
                        </div>

                        <div class="mt-5 overflow-hidden rounded-3xl border border-slate-200">
                            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                                <thead class="bg-slate-50 text-slate-500">
                                    <tr>
                                        <th class="px-4 py-3 font-medium">{{ __('messages.profile_intensity') }}</th>
                                        <th class="px-4 py-3 font-medium">{{ __('messages.methodology_cut_adjustment_label') }}</th>
                                        <th class="px-4 py-3 font-medium">{{ __('messages.methodology_bulk_adjustment_label') }}</th>
                                        <th class="px-4 py-3 font-medium">{{ __('messages.methodology_recommendation_label') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                                    <tr>
                                        <td class="px-4 py-3">{{ __('messages.intensity_mild') }}</td>
                                        <td class="px-4 py-3">-250 kcal</td>
                                        <td class="px-4 py-3">+250 kcal</td>
                                        <td class="px-4 py-3">{{ __('messages.methodology_intensity_mild_note') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">{{ __('messages.intensity_moderate') }}</td>
                                        <td class="px-4 py-3">-500 kcal</td>
                                        <td class="px-4 py-3">+500 kcal</td>
                                        <td class="px-4 py-3">{{ __('messages.methodology_intensity_moderate_note') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">{{ __('messages.intensity_aggressive') }}</td>
                                        <td class="px-4 py-3">-750 kcal</td>
                                        <td class="px-4 py-3">+750 kcal</td>
                                        <td class="px-4 py-3">{{ __('messages.methodology_intensity_aggressive_note') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </article>

            <article class="public-section-card">
                <div class="flex items-start gap-4">
                    <div class="public-icon-badge bg-cyan-100 text-cyan-700">4</div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xl font-semibold tracking-tight text-slate-900">{{ __('messages.methodology_macros_title') }}</h2>
                        <p class="descriptor-text">{{ __('messages.plan_protein') }} / {{ __('messages.plan_carbs') }} / {{ __('messages.plan_fat') }}</p>
                        <p class="mt-5 text-sm leading-7 text-slate-600">{{ __('messages.methodology_macros_intro') }}</p>

                        <div class="mt-5 overflow-hidden rounded-3xl border border-slate-200">
                            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                                <thead class="bg-slate-50 text-slate-500">
                                    <tr>
                                        <th class="px-4 py-3 font-medium">{{ __('messages.plan_goal') }}</th>
                                        <th class="px-4 py-3 font-medium">{{ __('messages.plan_protein') }}</th>
                                        <th class="px-4 py-3 font-medium">{{ __('messages.plan_carbs') }}</th>
                                        <th class="px-4 py-3 font-medium">{{ __('messages.plan_fat') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                                    <tr>
                                        <td class="px-4 py-3">{{ __('messages.goal_cut') }}</td>
                                        <td class="px-4 py-3">35%</td>
                                        <td class="px-4 py-3">40%</td>
                                        <td class="px-4 py-3">25%</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">{{ __('messages.goal_bulk') }}</td>
                                        <td class="px-4 py-3">25%</td>
                                        <td class="px-4 py-3">50%</td>
                                        <td class="px-4 py-3">25%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 rounded-3xl border border-slate-200 bg-slate-50 p-4 text-sm leading-6 text-slate-600">
                            {{ __('messages.methodology_macros_note') }}
                        </div>
                    </div>
                </div>
            </article>

            <article class="overflow-hidden rounded-[1.75rem] border border-amber-200 bg-amber-50/70 p-6 shadow-sm sm:p-7">
                <div class="flex items-start gap-4">
                    <div class="public-icon-badge bg-amber-100 text-amber-700">!</div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xl font-semibold tracking-tight text-amber-900">{{ __('messages.methodology_disclaimer_title') }}</h2>
                        <p class="mt-4 text-sm leading-7 text-amber-900/80">{{ __('messages.methodology_disclaimer_intro') }}</p>
                        <ul class="mt-4 space-y-2 text-sm leading-6 text-amber-900/80">
                            <li>{{ __('messages.methodology_disclaimer_item_1') }}</li>
                            <li>{{ __('messages.methodology_disclaimer_item_2') }}</li>
                            <li>{{ __('messages.methodology_disclaimer_item_3') }}</li>
                        </ul>
                    </div>
                </div>
            </article>

            <section class="public-section-card">
                <div class="section-header">
                    <div>
                        <h2 class="display-card-heading text-xl">{{ __('messages.methodology_cta_title') }}</h2>
                        <p class="display-card-description">{{ __('messages.methodology_cta_description') }}</p>
                    </div>

                    @auth
                        <a href="{{ route('plans.current') }}" class="btn-ui btn-ui-md btn-ui-primary">
                            {{ __('messages.plan_generate_button') }}
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-ui btn-ui-md btn-ui-primary">
                            {{ __('messages.home_get_started') }}
                        </a>
                    @endauth
                </div>
            </section>
        </section>
    </div>
@endsection
