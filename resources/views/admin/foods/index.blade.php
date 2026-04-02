@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="page-header">
            <div>
                <p class="page-kicker">{{ __('messages.app_name') }}</p>
                <h1 class="page-title mt-2">{{ __('messages.admin_foods_title') }}</h1>
                <p class="page-description mt-3">{{ __('messages.admin_foods_description') }}</p>
            </div>

            <a href="{{ route('admin.foods.create') }}" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                {{ __('messages.admin_food_create') }}
            </a>
        </section>

        @if ($foods->isEmpty())
            <section class="empty-state-card">
                <div class="empty-state-icon">AF</div>
                <h2 class="mt-4 text-lg font-semibold text-slate-900">{{ __('messages.food_empty') }}</h2>
                <p class="mx-auto mt-2 max-w-xl text-sm leading-6 text-slate-600">
                    {{ __('messages.admin_foods_description') }}
                </p>
                <div class="mt-5">
                    <a href="{{ route('admin.foods.create') }}" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                        {{ __('messages.admin_food_create') }}
                    </a>
                </div>
            </section>
        @else
            <section class="section-card p-0 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr class="text-slate-500">
                                <th>{{ __('messages.food_name') }}</th>
                                <th>{{ __('messages.food_category') }}</th>
                                <th>{{ __('messages.food_calories_per_100g') }}</th>
                                <th>{{ __('messages.food_verified') }}</th>
                                <th>{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($foods as $food)
                                <tr class="hover">
                                    <td>
                                        <div class="font-medium text-slate-900">{{ $food->name }}</div>
                                        <div class="text-sm text-slate-500">{{ $food->name_zh ?: '-' }}</div>
                                    </td>
                                    <td>{{ __('messages.food_category_' . $food->category) }}</td>
                                    <td>{{ $food->calories_per_100g }}</td>
                                    <td>
                                        @if ($food->is_verified)
                                            <span class="badge badge-success rounded-full">{{ __('messages.yes') }}</span>
                                        @else
                                            <span class="badge badge-outline rounded-full text-slate-600">{{ __('messages.no') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('admin.foods.edit', $food) }}" class="btn btn-outline btn-sm rounded-full border-slate-200 normal-case text-slate-700 hover:border-slate-300 hover:bg-slate-50">
                                                {{ __('messages.edit') }}
                                            </a>

                                            <form action="{{ route('admin.foods.destroy', $food) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-error btn-sm rounded-full border-0 normal-case">
                                                    {{ __('messages.delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif

        {{ $foods->links() }}
    </div>
@endsection
