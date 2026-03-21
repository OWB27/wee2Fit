@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h1 class="card-title text-3xl">{{ $food->displayName() }}</h1>

                <p class="text-base-content/70">
                    {{ __('messages.food_category_' . $food->category) }}
                </p>

                <div class="grid gap-4 md:grid-cols-2 mt-4">
                    <div class="stats shadow">
                        <div class="stat">
                            <div class="stat-title">{{ __('messages.food_calories_per_100g') }}</div>
                            <div class="stat-value text-primary">{{ $food->calories_per_100g }}</div>
                        </div>
                    </div>

                    <div class="stats shadow">
                        <div class="stat">
                            <div class="stat-title">{{ __('messages.food_verified') }}</div>
                            <div class="stat-value text-sm">
                                {{ $food->is_verified ? __('messages.yes') : __('messages.no') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-3 mt-6">
                    <div class="card bg-base-200">
                        <div class="card-body">
                            <h2 class="card-title">{{ __('messages.plan_protein') }}</h2>
                            <p class="text-2xl font-bold">{{ $food->protein_per_100g }} g</p>
                        </div>
                    </div>

                    <div class="card bg-base-200">
                        <div class="card-body">
                            <h2 class="card-title">{{ __('messages.plan_carbs') }}</h2>
                            <p class="text-2xl font-bold">{{ $food->carbs_per_100g }} g</p>
                        </div>
                    </div>

                    <div class="card bg-base-200">
                        <div class="card-body">
                            <h2 class="card-title">{{ __('messages.plan_fat') }}</h2>
                            <p class="text-2xl font-bold">{{ $food->fat_per_100g }} g</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('foods.index') }}" class="btn btn-outline">
                        {{ __('messages.back_to_food_library') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection