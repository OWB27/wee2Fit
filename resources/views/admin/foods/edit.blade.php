@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="page-header">
            <div>
                <p class="page-kicker">{{ __('messages.app_name') }}</p>
                <h1 class="page-title mt-2">{{ __('messages.admin_food_edit_title') }}</h1>
                <p class="page-description mt-3">{{ __('messages.admin_food_edit_description') }}</p>
            </div>
        </section>

        <section class="layout-main-aside-compact">
            <form action="{{ route('admin.foods.update', $food) }}" method="POST" enctype="multipart/form-data" class="section-card space-y-6">
                @method('PUT')

                <div>
                    <h2 class="display-card-heading">{{ __('messages.admin_food_details_title') }}</h2>
                    <p class="display-card-description">{{ __('messages.admin_food_details_description') }}</p>
                </div>

                @include('admin.foods._form')
            </form>

            <aside class="space-y-4">
                <div class="section-card border-red-100">
                    <h2 class="display-card-heading">{{ __('messages.admin_danger_zone') }}</h2>
                    <p class="display-card-description">{{ __('messages.admin_food_delete_description') }}</p>

                    <form action="{{ route('admin.foods.destroy', $food) }}" method="POST" class="mt-5">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn-ui btn-ui-md btn-ui-danger w-full">
                            {{ __('messages.delete') }}
                        </button>
                    </form>
                </div>
            </aside>
        </section>
    </div>
@endsection
