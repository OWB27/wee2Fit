@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="page-header">
            <div>
                <p class="page-kicker">{{ __('messages.app_name') }}</p>
                <h1 class="page-title mt-2">{{ __('messages.admin_foods_title') }}</h1>
                <p class="page-description mt-3">{{ __('messages.admin_foods_description') }}</p>
            </div>

            <a href="{{ route('admin.foods.create') }}" class="btn-ui btn-ui-md btn-ui-primary">
                {{ __('messages.admin_food_create') }}
            </a>
        </section>

        @if ($foods->isEmpty())
            <section class="empty-state-card">
                <div class="empty-state-icon">AF</div>
                <h2 class="empty-state-title">{{ __('messages.food_empty') }}</h2>
                <p class="empty-state-description">
                    {{ __('messages.admin_foods_description') }}
                </p>
                <div class="mt-5">
                    <a href="{{ route('admin.foods.create') }}" class="btn-ui btn-ui-md btn-ui-primary">
                        {{ __('messages.admin_food_create') }}
                    </a>
                </div>
            </section>
        @else
            <section class="section-card-table">
                <div class="table-scroll-shell">
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
                                            <span class="badge-ui badge-ui-success">{{ __('messages.yes') }}</span>
                                        @else
                                            <span class="badge-ui badge-ui-neutral">{{ __('messages.no') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="table-action-cell">
                                            <a href="{{ route('admin.foods.edit', $food) }}" class="btn-ui btn-ui-sm btn-ui-secondary">
                                                {{ __('messages.edit') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif

        <div class="pagination-shell">
            {{ $foods->links() }}
        </div>
    </div>
@endsection
