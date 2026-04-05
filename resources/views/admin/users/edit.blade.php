@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="page-header">
            <div>
                <p class="page-kicker">{{ __('messages.app_name') }}</p>
                <h1 class="page-title mt-2">{{ __('messages.admin_user_edit_title') }}</h1>
                <p class="page-description mt-3">{{ __('messages.admin_user_edit_description') }}</p>
            </div>
        </section>

        <section class="layout-main-aside-compact">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="section-card form-section">
                @csrf
                @method('PUT')

                <div>
                    <h2 class="form-section-heading">{{ __('messages.admin_user_identity_title') }}</h2>
                    <p class="form-section-description">{{ __('messages.admin_user_identity_description') }}</p>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="key-stat">
                        <div class="key-stat-label">{{ __('messages.admin_users_name') }}</div>
                        <div class="key-stat-value">{{ $user->name }}</div>
                    </div>

                    <div class="key-stat">
                        <div class="key-stat-label">{{ __('messages.admin_users_email') }}</div>
                        <div class="key-stat-value break-all">{{ $user->email }}</div>
                    </div>

                    <div class="key-stat">
                        <div class="key-stat-label">{{ __('messages.admin_users_role') }}</div>
                        <div class="key-stat-value">
                            {{ $user->isAdmin() ? __('messages.admin_users_role_admin') : __('messages.admin_users_role_user') }}
                        </div>
                    </div>

                    <div class="key-stat">
                        <div class="key-stat-label">{{ __('messages.admin_users_status') }}</div>
                        <div class="key-stat-value">
                            {{ $user->isActive() ? __('messages.admin_users_status_active') : __('messages.admin_users_status_inactive') }}
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-200 pt-6">
                    <h2 class="form-section-heading">{{ __('messages.admin_user_tags_title') }}</h2>
                    <p class="form-section-description">{{ __('messages.admin_user_tags_description') }}</p>

                    <div class="mt-5 grid gap-3 md:grid-cols-2">
                        @foreach ($availableTags as $tag)
                            <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-700 transition hover:border-green-200 hover:bg-green-50">
                                <input
                                    type="checkbox"
                                    name="user_tag_ids[]"
                                    value="{{ $tag->id }}"
                                    class="form-checkbox mt-0.5"
                                    @checked($user->tags->contains('id', $tag->id))
                                >
                                <span class="font-medium">{{ $tag->displayName() }}</span>
                            </label>
                        @endforeach
                    </div>

                    @error('user_tag_ids')
                        <p class="form-error mt-3">{{ $message }}</p>
                    @enderror

                    @error('user_tag_ids.*')
                        <p class="form-error mt-3">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-ui btn-ui-md btn-ui-primary">
                        {{ __('messages.save') }}
                    </button>

                    <a href="{{ route('admin.users.index') }}" class="btn-ui btn-ui-md btn-ui-secondary">
                        {{ __('messages.admin_users_title') }}
                    </a>
                </div>
            </form>

            <aside class="space-y-4">
                <div class="section-card border-red-100">
                    <h2 class="form-section-heading">{{ __('messages.admin_danger_zone') }}</h2>
                    <p class="form-section-description">{{ __('messages.admin_user_status_manage_description') }}</p>

                    @if (auth()->id() === $user->id)
                        <p class="mt-5 text-sm text-slate-500">{{ __('messages.admin_users_current_you') }}</p>
                    @else
                        <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" class="mt-5">
                            @csrf
                            @method('PATCH')

                            @if ($user->isActive())
                                <button type="submit" class="btn-ui btn-ui-md btn-ui-danger w-full">
                                    {{ __('messages.admin_users_disable') }}
                                </button>
                            @else
                                <button type="submit" class="btn-ui btn-ui-md btn-ui-primary w-full">
                                    {{ __('messages.admin_users_enable') }}
                                </button>
                            @endif
                        </form>
                    @endif
                </div>
            </aside>
        </section>
    </div>
@endsection
