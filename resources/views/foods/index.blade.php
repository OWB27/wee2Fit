@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="public-hero">
            <div class="public-hero-grid">
                <div class="space-y-4">
                    <p class="page-kicker">{{ __('messages.app_name') }}</p>
                    <h1 class="page-title mt-3">{{ __('messages.food_library_title') }}</h1>
                    <p class="page-description mt-4">{{ __('messages.food_library_description') }}</p>
                </div>
            </div>
        </section>

        <section class="public-filter-shell">
            <div class="filter-chip-row">
                <a href="{{ route('foods.index') }}" class="{{ $category ? 'btn-ui btn-ui-sm btn-ui-secondary' : 'btn-ui btn-ui-sm btn-ui-primary' }}">
                    {{ __('messages.food_category_all') }}
                </a>

                @foreach ($categories as $item)
                    <a
                        href="{{ route('foods.index', ['category' => $item]) }}"
                        class="{{ $category === $item ? 'btn-ui btn-ui-sm btn-ui-primary' : 'btn-ui btn-ui-sm btn-ui-secondary' }}"
                    >
                        {{ __('messages.food_category_' . $item) }}
                    </a>
                @endforeach
            </div>
        </section>

        <section class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            @forelse ($foods as $food)
                <article class="food-library-card">
                    <div class="food-library-media">
                        @if ($food->is_verified)
                            <span class="food-library-badge">
                                {{ __('messages.food_verified') }}
                            </span>
                        @endif

                        @if ($food->imageUrl())
                            <img
                                src="{{ $food->imageUrl() }}"
                                alt="{{ $food->displayName() }}"
                                class="food-library-image"
                            >
                        @else
                            <div class="food-library-icon-wrap">
                                <span class="{{ $food->categoryPlaceholderClass() }}">{{ $food->categoryPlaceholderLabel() }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="food-library-body">
                        <div>
                            <h2 class="text-lg font-semibold tracking-tight text-slate-900">{{ $food->displayName() }}</h2>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            <span class="food-library-category-pill {{ $food->categoryPillClass() }}">
                                {{ __('messages.food_category_' . $food->category) }}
                            </span>
                        </div>

                        <div class="food-library-energy">
                            <div>
                                <div class="flex items-end gap-2">
                                    <span class="food-library-energy-value">{{ $food->formattedCaloriesPer100g() }}</span>
                                    <span class="pb-0.5 text-xs text-slate-500">kcal / 100g</span>
                                </div>
                            </div>
                        </div>

                        <div class="food-library-macro-grid">
                            <div class="food-library-macro-card bg-rose-50 text-rose-600">
                                <div class="mt-1.5 text-base font-semibold">{{ $food->formattedProteinPer100g() }}g</div>
                                <div class="mt-1 text-[10px] font-medium uppercase tracking-[0.12em]">{{ __('messages.plan_protein') }}</div>
                            </div>

                            <div class="food-library-macro-card bg-amber-50 text-amber-600">
                                <div class="mt-1.5 text-base font-semibold">{{ $food->formattedCarbsPer100g() }}g</div>
                                <div class="mt-1 text-[10px] font-medium uppercase tracking-[0.12em]">{{ __('messages.plan_carbs') }}</div>
                            </div>

                            <div class="food-library-macro-card bg-sky-50 text-sky-600">
                                <div class="mt-1.5 text-base font-semibold">{{ $food->formattedFatPer100g() }}g</div>
                                <div class="mt-1 text-[10px] font-medium uppercase tracking-[0.12em]">{{ __('messages.plan_fat') }}</div>
                            </div>
                        </div>

                        <div class="pt-1">
                            <a href="{{ route('foods.show', $food) }}" class="btn-ui btn-ui-sm btn-ui-secondary w-full">
                                {{ __('messages.food_view_details') }}
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full empty-state-card">
                    <div class="empty-state-icon">FD</div>
                    <h2 class="empty-state-title">{{ __('messages.food_empty') }}</h2>
                    <p class="empty-state-description">
                        {{ __('messages.food_library_description') }}
                    </p>
                </div>
            @endforelse
        </section>

        <div class="pagination-shell">
            {{ $foods->links() }}
        </div>
    </div>
@endsection
