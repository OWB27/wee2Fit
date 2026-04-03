@extends('layouts.workspace')

@section('content')
    <div class="workspace-content-stack">
        <section class="flex flex-col gap-3">
            <h1 class="workspace-page-title">{{ __('messages.weekly_plan_create') }}</h1>
            <p class="workspace-page-description">{{ __('messages.weekly_plans_description') }}</p>
        </section>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1.4fr),340px]">
            <section class="workspace-field-shell">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.weekly_plan_basic_info') }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.weekly_plan_note') }}</p>
                </div>

                <form action="{{ route('weekly-plans.store') }}" method="POST" class="mt-6">
                    @include('weekly-plans._form')
                </form>
            </section>

            <aside class="space-y-4">
                <div class="workspace-soft-card">
                    <div class="text-sm font-semibold text-emerald-700">{{ __('messages.weekly_plan_planner') }}</div>
                    <div class="mt-4 text-3xl font-semibold tracking-tight text-slate-900">{{ __('messages.weekly_plans_title') }}</div>
                    <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.weekly_plans_description') }}</p>
                </div>

                <div class="workspace-card space-y-4">
                    <div class="flex items-start gap-3">
                        <span class="public-icon-badge h-9 w-9 text-xs">1</span>
                        <div>
                            <h3 class="text-sm font-semibold text-slate-900">{{ __('messages.weekly_plan_basic_info') }}</h3>
                            <p class="mt-1 text-sm leading-6 text-slate-600">{{ __('messages.weekly_plan_week_start_date') }} / {{ __('messages.weekly_plan_note') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="public-icon-badge h-9 w-9 bg-sky-100 text-xs text-sky-700">2</span>
                        <div>
                            <h3 class="text-sm font-semibold text-slate-900">{{ __('messages.weekly_plan_planner') }}</h3>
                            <p class="mt-1 text-sm leading-6 text-slate-600">{{ __('messages.weekly_plan_add_food_button') }} / {{ __('messages.weekly_summary_title') }}</p>
                        </div>
                    </div>
                </div>

                <div class="workspace-helper-card">
                    <div class="text-sm font-semibold text-slate-900">{{ __('messages.plan_generate_title') }}</div>
                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        {{ __('messages.weekly_plans_description') }}
                    </p>
                </div>
            </aside>
        </div>
    </div>
@endsection
