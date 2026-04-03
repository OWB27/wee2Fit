@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="public-hero">
            <div class="public-hero-grid">
                <div>
                    <p class="page-kicker">{{ __('messages.app_name') }}</p>
                    <h1 class="page-title mt-3">{{ __('messages.food_library_title') }}</h1>
                    <p class="page-description mt-4">{{ __('messages.food_library_description') }}</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="public-stat-card">
                        <div class="text-sm text-slate-500">{{ __('messages.food_category') }}</div>
                        <div class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ count($categories) }}</div>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.food_category_all') }}</p>
                    </div>

                    <div class="public-soft-panel">
                        <div class="text-sm text-slate-500">{{ __('messages.food_library_title') }}</div>
                        <div class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $foods->total() }}</div>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.food_view_details') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="public-filter-shell">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('foods.index') }}" class="btn btn-sm rounded-full {{ $category ? 'btn-outline border-slate-200 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50' : 'btn-primary border-0 normal-case shadow-sm' }}">
                    {{ __('messages.food_category_all') }}
                </a>

                @foreach ($categories as $item)
                    <a
                        href="{{ route('foods.index', ['category' => $item]) }}"
                        class="btn btn-sm rounded-full {{ $category === $item ? 'btn-primary border-0 normal-case shadow-sm' : 'btn-outline border-slate-200 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50' }}"
                    >
                        {{ __('messages.food_category_' . $item) }}
                    </a>
                @endforeach
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($foods as $food)
                <article class="public-food-card">
                    <div class="flex h-full flex-col gap-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">{{ $food->displayName() }}</h2>
                                <p class="mt-2 text-sm text-slate-500">{{ __('messages.food_category_' . $food->category) }}</p>
                            </div>

                            @if ($food->is_verified)
                                <span class="badge rounded-full border-0 bg-emerald-100 px-3 py-3 text-emerald-700">
                                    {{ __('messages.food_verified') }}
                                </span>
                            @endif
                        </div>

                        <div class="grid gap-3 sm:grid-cols-3">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                                <div class="text-xs uppercase tracking-[0.14em] text-slate-400">kcal</div>
                                <div class="mt-2 text-lg font-semibold text-slate-900">{{ $food->calories_per_100g }}</div>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                                <div class="text-xs uppercase tracking-[0.14em] text-slate-400">{{ __('messages.plan_protein') }}</div>
                                <div class="mt-2 text-lg font-semibold text-slate-900">{{ $food->protein_per_100g }}</div>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                                <div class="text-xs uppercase tracking-[0.14em] text-slate-400">{{ __('messages.plan_carbs') }}</div>
                                <div class="mt-2 text-lg font-semibold text-slate-900">{{ $food->carbs_per_100g }}</div>
                            </div>
                        </div>

                        <div class="mt-auto flex items-center justify-between gap-3 pt-2">
                            <div class="text-sm text-slate-500">{{ __('messages.food_calories_per_100g') }}</div>
                            <a href="{{ route('foods.show', $food) }}" class="btn btn-primary btn-sm rounded-full border-0 px-4 normal-case shadow-sm">
                                {{ __('messages.food_view_details') }}
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full empty-state-card">
                    <div class="empty-state-icon">FD</div>
                    <h2 class="mt-4 text-lg font-semibold text-slate-900">{{ __('messages.food_empty') }}</h2>
                    <p class="mx-auto mt-2 max-w-xl text-sm leading-6 text-slate-600">
                        {{ __('messages.food_library_description') }}
                    </p>
                </div>
            @endforelse
        </section>

        <div>
            {{ $foods->links() }}
        </div>
    </div>
@endsection
