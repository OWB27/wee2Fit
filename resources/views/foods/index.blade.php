@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">{{ __('messages.food_library_title') }}</h1>
                <p class="text-base-content/70">{{ __('messages.food_library_description') }}</p>
            </div>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('foods.index') }}" class="btn btn-sm {{ $category ? 'btn-outline' : 'btn-primary' }}">
                {{ __('messages.food_category_all') }}
            </a>

            @foreach ($categories as $item)
                <a
                    href="{{ route('foods.index', ['category' => $item]) }}"
                    class="btn btn-sm {{ $category === $item ? 'btn-primary' : 'btn-outline' }}"
                >
                    {{ __('messages.food_category_' . $item) }}
                </a>
            @endforeach
        </div>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($foods as $food)
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <h2 class="card-title">{{ $food->displayName() }}</h2>
                        <p class="text-sm text-base-content/70">
                            {{ __('messages.food_category_' . $food->category) }}
                        </p>
                        <p>{{ __('messages.food_calories_per_100g') }}: {{ $food->calories_per_100g }}</p>

                        <div class="card-actions justify-end">
                            <a href="{{ route('foods.show', $food) }}" class="btn btn-primary btn-sm">
                                {{ __('messages.food_view_details') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p>{{ __('messages.food_empty') }}</p>
            @endforelse
        </div>

        {{ $foods->links() }}
    </div>
@endsection