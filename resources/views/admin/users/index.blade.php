@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="page-header">
            <div>
                <p class="page-kicker">{{ __('messages.app_name') }}</p>
                <h1 class="page-title mt-2">{{ __('messages.admin_users_title') }}</h1>
                <p class="page-description mt-3">{{ __('messages.admin_users_description') }}</p>
            </div>
        </section>

        @if ($users->isEmpty())
            <section class="empty-state-card">
                <div class="empty-state-icon">AU</div>
                <h2 class="empty-state-title">{{ __('messages.admin_users_empty') }}</h2>
                <p class="empty-state-description">
                    {{ __('messages.admin_users_description') }}
                </p>
            </section>
        @else
            <section class="section-card-table">
                <div class="table-scroll-shell">
                    <table class="table">
                        <thead>
                            <tr class="text-slate-500">
                                <th>ID</th>
                                <th>{{ __('messages.admin_users_name') }}</th>
                                <th>{{ __('messages.admin_users_email') }}</th>
                                <th>{{ __('messages.admin_users_role') }}</th>
                                <th>{{ __('messages.admin_users_status') }}</th>
                                <th>{{ __('messages.admin_user_tags_title') }}</th>
                                <th>{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="hover">
                                    <td>{{ $user->id }}</td>
                                    <td class="font-medium text-slate-900">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->isAdmin())
                                            <span class="badge-ui badge-ui-info">{{ __('messages.admin_users_role_admin') }}</span>
                                        @else
                                            <span class="badge-ui badge-ui-neutral">{{ __('messages.admin_users_role_user') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->isActive())
                                            <span class="badge-ui badge-ui-success">{{ __('messages.admin_users_status_active') }}</span>
                                        @else
                                            <span class="badge-ui badge-ui-danger">{{ __('messages.admin_users_status_inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex flex-wrap gap-2">
                                            @forelse ($user->tags as $tag)
                                                <span class="badge-ui badge-ui-brand badge-ui-sm">
                                                    {{ $tag->displayName() }}
                                                </span>
                                            @empty
                                                <span class="text-sm text-slate-500">{{ __('messages.admin_user_no_tags') }}</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td>
                                        <div class="table-action-cell">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-ui btn-ui-sm btn-ui-secondary">
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
    </div>
@endsection
