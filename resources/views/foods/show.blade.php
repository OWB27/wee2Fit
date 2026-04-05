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
                    @if ($food->imageUrl())
                        <div class="overflow-hidden rounded-[1.5rem] border border-emerald-100 bg-white/70 shadow-sm">
                            <img src="{{ $food->imageUrl() }}" alt="{{ $food->displayName() }}" class="h-64 w-full object-cover">
                        </div>
                    @else
                        <div class="flex h-64 items-center justify-center rounded-[1.5rem] border border-dashed border-emerald-200 bg-white/60 text-sm text-slate-500">
                            {{ __('messages.food_no_image_yet') }}
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-3">
            <div class="public-soft-panel">
                <div class="text-sm font-semibold uppercase tracking-[0.2em] text-green-700">{{ __('messages.food_calories_per_100g') }}</div>
                <p class="note-text">
                    {{ __('messages.food_verified') }}:
                    <span class="font-medium text-slate-900">{{ $food->is_verified ? __('messages.yes') : __('messages.no') }}</span>
                </p>
                <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $food->calories_per_100g }} kcal</p>
            </div>

            <div class="public-section-card">
                <h2 class="display-card-heading">{{ __('messages.plan_protein') }}</h2>
                <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $food->protein_per_100g }} g</p>
            </div>

            <div class="public-section-card">
                <h2 class="display-card-heading">{{ __('messages.plan_carbs') }}</h2>
                <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $food->carbs_per_100g }} g</p>
            </div>

            <div class="public-section-card">
                <h2 class="display-card-heading">{{ __('messages.plan_fat') }}</h2>
                <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $food->fat_per_100g }} g</p>
            </div>
        </section>

        <section class="public-section-card">
            <div class="section-header">
                <div>
                    <h2 class="display-card-heading">{{ __('messages.food_library_title') }}</h2>
                    <p class="display-card-description">{{ __('messages.food_library_description') }}</p>
                </div>

                <a href="{{ route('foods.index') }}" class="btn-ui btn-ui-md btn-ui-secondary">
                    {{ __('messages.back_to_food_library') }}
                </a>
            </div>
        </section>
    </div>
@endsection
