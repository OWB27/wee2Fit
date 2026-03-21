@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-3xl font-bold">{{ __('messages.admin_users_title') }}</h1>
            <p class="text-base-content/70">{{ __('messages.admin_users_description') }}</p>
        </div>

        <div class="overflow-x-auto bg-base-100 shadow rounded-box">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('messages.admin_users_name') }}</th>
                        <th>{{ __('messages.admin_users_email') }}</th>
                        <th>{{ __('messages.admin_users_role') }}</th>
                        <th>{{ __('messages.admin_users_status') }}</th>
                        <th>{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->isAdmin())
                                    <span class="badge badge-primary">{{ __('messages.admin_users_role_admin') }}</span>
                                @else
                                    <span class="badge badge-outline">{{ __('messages.admin_users_role_user') }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->isActive())
                                    <span class="badge badge-success">{{ __('messages.admin_users_status_active') }}</span>
                                @else
                                    <span class="badge badge-error">{{ __('messages.admin_users_status_inactive') }}</span>
                                @endif
                            </td>
                            <td>
                                @if (auth()->id() === $user->id)
                                    <span class="text-sm text-base-content/60">
                                        {{ __('messages.admin_users_current_you') }}
                                    </span>
                                @else
                                    <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        @if ($user->isActive())
                                            <button type="submit" class="btn btn-sm btn-error">
                                                {{ __('messages.admin_users_disable') }}
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-success">
                                                {{ __('messages.admin_users_enable') }}
                                            </button>
                                        @endif
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">{{ __('messages.admin_users_empty') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection