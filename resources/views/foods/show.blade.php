@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="public-hero">
            <div class="public-hero-grid">
                <div>
                    <p class="page-kicker">{{ __('messages.app_name') }}</p>
                    <h1 class="page-title mt-3">{{ $food->displayName() }}</h1>
                    <p class="page-description mt-4">{{ __('messages.food_category_' . $food->category) }}</p>

                    @if ($food->name !== $food->displayName() || $food->name_zh)
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="workspace-chip">
                                {{ __('messages.food_name_en') }}: {{ $food->name }}
                            </span>
                            @if ($food->name_zh)
                                <span class="workspace-chip">
                                    {{ __('messages.food_name_zh') }}: {{ $food->name_zh }}
                                </span>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="public-soft-panel">
                    <div class="text-sm font-semibold uppercase tracking-[0.2em] text-green-700">{{ __('messages.food_calories_per_100g') }}</div>
                    <div class="mt-4 text-4xl font-semibold tracking-tight text-slate-900">{{ $food->calories_per_100g }}</div>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        {{ __('messages.food_verified') }}:
                        <span class="font-medium text-slate-900">{{ $food->is_verified ? __('messages.yes') : __('messages.no') }}</span>
                    </p>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-3">
            <div class="public-soft-panel">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.plan_protein') }}</h2>
                <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $food->protein_per_100g }} g</p>
            </div>

            <div class="public-section-card">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.plan_carbs') }}</h2>
                <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $food->carbs_per_100g }} g</p>
            </div>

            <div class="public-section-card">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.plan_fat') }}</h2>
                <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $food->fat_per_100g }} g</p>
            </div>
        </section>

        @if ($food->image_path)
            <section class="public-section-card">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.food_image_path') }}</h2>
                <p class="mt-3 break-all text-sm leading-6 text-slate-600">{{ $food->image_path }}</p>
            </section>
        @endif

        <section class="public-section-card">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.food_library_title') }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.food_library_description') }}</p>
                </div>

                <a href="{{ route('foods.index') }}" class="btn btn-outline rounded-full border-slate-200 px-5 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                    {{ __('messages.back_to_food_library') }}
                </a>
            </div>
        </section>
    </div>
@endsection
