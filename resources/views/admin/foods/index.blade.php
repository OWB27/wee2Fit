@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">{{ __('messages.admin_foods_title') }}</h1>
                <p class="text-base-content/70">{{ __('messages.admin_foods_description') }}</p>
            </div>

            <a href="{{ route('admin.foods.create') }}" class="btn btn-primary">
                {{ __('messages.admin_food_create') }}
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto bg-base-100 shadow rounded-box">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('messages.food_name') }}</th>
                        <th>{{ __('messages.food_category') }}</th>
                        <th>{{ __('messages.food_calories_per_100g') }}</th>
                        <th>{{ __('messages.food_verified') }}</th>
                        <th>{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($foods as $food)
                        <tr>
                            <td>{{ $food->name }}</td>
                            <td>{{ __('messages.food_category_' . $food->category) }}</td>
                            <td>{{ $food->calories_per_100g }}</td>
                            <td>{{ $food->is_verified ? __('messages.yes') : __('messages.no') }}</td>
                            <td class="flex gap-2">
                                <a href="{{ route('admin.foods.edit', $food) }}" class="btn btn-sm btn-outline">
                                    {{ __('messages.edit') }}
                                </a>

                                <form action="{{ route('admin.foods.destroy', $food) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-error">
                                        {{ __('messages.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">{{ __('messages.food_empty') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $foods->links() }}
    </div>
@endsection