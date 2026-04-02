@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="page-header">
            <div>
                <p class="page-kicker">{{ __('messages.app_name') }}</p>
                <h1 class="page-title mt-2">{{ __('messages.food_library_title') }}</h1>
                <p class="page-description mt-3">{{ __('messages.food_library_description') }}</p>
            </div>
        </section>

        <section class="surface-card p-5 sm:p-6">
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

        <section class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($foods as $food)
                <div class="surface-card h-full p-6">
                    <div class="flex h-full flex-col gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">{{ $food->displayName() }}</h2>
                            <p class="mt-2 text-sm text-slate-500">
                                {{ __('messages.food_category_' . $food->category) }}
                            </p>
                            <p class="mt-4 text-sm text-slate-700">
                                {{ __('messages.food_calories_per_100g') }}: <span class="font-semibold text-slate-900">{{ $food->calories_per_100g }}</span>
                            </p>
                        </div>

                        <div class="mt-auto">
                            <a href="{{ route('foods.show', $food) }}" class="btn btn-primary btn-sm rounded-full border-0 px-4 normal-case shadow-sm">
                                {{ __('messages.food_view_details') }}
                            </a>
                        </div>
                    </div>
                </div>
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

        {{ $foods->links() }}
    </div>
@endsection
