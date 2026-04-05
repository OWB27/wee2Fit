@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="page-header">
            <div>
                <p class="page-kicker">{{ __('messages.app_name') }}</p>
                <h1 class="page-title mt-2">{{ __('messages.admin_food_create_title') }}</h1>
                <p class="page-description mt-3">{{ __('messages.admin_food_create_description') }}</p>
            </div>
        </section>

        <section class="layout-main-aside-compact">
            <form action="{{ route('admin.foods.store') }}" method="POST" enctype="multipart/form-data" class="section-card form-section">
                <div>
                    <h2 class="form-section-heading">{{ __('messages.admin_food_details_title') }}</h2>
                    <p class="form-section-description">{{ __('messages.admin_food_create_form_description') }}</p>
                </div>

                @include('admin.foods._form')
            </form>

            <aside class="space-y-4">
                <div class="section-card border-emerald-100 bg-emerald-50/60">
                    <h2 class="form-section-heading">{{ __('messages.admin_food_create_tips_title') }}</h2>
                    <p class="form-section-description">{{ __('messages.admin_food_create_tips_description') }}</p>

                    <ul class="mt-4 space-y-3 text-sm leading-6 text-slate-700">
                        <li>{{ __('messages.admin_food_create_tip_names') }}</li>
                        <li>{{ __('messages.admin_food_create_tip_nutrition') }}</li>
                        <li>{{ __('messages.admin_food_create_tip_image') }}</li>
                    </ul>
                </div>
            </aside>
        </section>
    </div>
@endsection
