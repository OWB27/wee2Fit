@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl page-stack">
        <section class="surface-card overflow-hidden">
            <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-[1.1fr,0.9fr] lg:p-10">
                <div>
                    <p class="page-kicker">{{ __('messages.app_name') }}</p>
                    <h1 class="page-title mt-3">{{ $food->displayName() }}</h1>
                    <p class="page-description mt-4">{{ __('messages.food_category_' . $food->category) }}</p>

                    @if ($food->name !== $food->displayName() || $food->name_zh)
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-700">
                                EN: {{ $food->name }}
                            </span>
                            @if ($food->name_zh)
                                <span class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-700">
                                    ZH: {{ $food->name_zh }}
                                </span>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="surface-card-soft p-6">
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
            <div class="surface-card-soft p-6">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.plan_protein') }}</h2>
                <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $food->protein_per_100g }} g</p>
            </div>

            <div class="section-card">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.plan_carbs') }}</h2>
                <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $food->carbs_per_100g }} g</p>
            </div>

            <div class="section-card">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.plan_fat') }}</h2>
                <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $food->fat_per_100g }} g</p>
            </div>
        </section>

        @if ($food->image_path)
            <section class="section-card">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.food_image_path') }}</h2>
                <p class="mt-3 break-all text-sm leading-6 text-slate-600">{{ $food->image_path }}</p>
            </section>
        @endif

        <section class="section-card">
            <a href="{{ route('foods.index') }}" class="btn btn-outline rounded-full border-slate-200 px-5 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                {{ __('messages.back_to_food_library') }}
            </a>
        </section>
    </div>
@endsection
