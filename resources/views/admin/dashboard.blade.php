@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl page-stack">
        <section class="surface-card overflow-hidden">
            <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-[1.1fr,0.9fr] lg:p-10">
                <div>
                    <p class="page-kicker">{{ __('messages.app_name') }}</p>
                    <h1 class="page-title mt-3">{{ __('messages.admin_dashboard_title') }}</h1>
                    <p class="page-description mt-4">{{ __('messages.admin_dashboard_description') }}</p>
                </div>

                <div class="surface-card-soft p-6">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-sm font-semibold text-green-700 shadow-sm">1</span>
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900">{{ __('messages.admin_foods_title') }}</h2>
                                <p class="mt-1 text-sm leading-6 text-slate-600">{{ __('messages.admin_foods_description') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-sm font-semibold text-green-700 shadow-sm">2</span>
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900">{{ __('messages.admin_users_title') }}</h2>
                                <p class="mt-1 text-sm leading-6 text-slate-600">{{ __('messages.admin_users_description') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2">
            <div class="section-card">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.admin_foods_title') }}</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.admin_foods_description') }}</p>
                <div class="mt-5">
                    <a href="{{ route('admin.foods.index') }}" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                        {{ __('messages.admin_manage_foods') }}
                    </a>
                </div>
            </div>

            <div class="section-card">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.admin_users_title') }}</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.admin_users_description') }}</p>
                <div class="mt-5">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                        {{ __('messages.admin_manage_users') }}
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
