@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl page-stack">
        <section class="surface-card overflow-hidden">
            <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-[1.05fr,0.95fr] lg:p-10">
                <div>
                    <p class="page-kicker">{{ __('messages.app_name') }}</p>
                    <h1 class="page-title mt-3">{{ __('messages.my_profile_title') }}</h1>
                    <p class="page-description mt-4">
                        {{ __('messages.my_profile_description') }}
                    </p>
                </div>

                <div class="surface-card-soft p-6">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-sm font-semibold text-green-700 shadow-sm">1</span>
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900">{{ __('messages.profile_sex') }} / {{ __('messages.profile_birth_date') }}</h2>
                                <p class="mt-1 text-sm leading-6 text-slate-600">{{ __('messages.plan_generate_description') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-sm font-semibold text-green-700 shadow-sm">2</span>
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900">{{ __('messages.profile_activity_level') }} / {{ __('messages.profile_goal') }}</h2>
                                <p class="mt-1 text-sm leading-6 text-slate-600">{{ __('messages.dashboard_plan_text') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-sm font-semibold text-green-700 shadow-sm">3</span>
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900">{{ __('messages.profile_intensity') }}</h2>
                                <p class="mt-1 text-sm leading-6 text-slate-600">{{ __('messages.progress_description') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-card">
            <form action="{{ route('my-profile.update') }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid gap-8 lg:grid-cols-2">
                    <div class="space-y-5">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.my_profile_title') }}</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.plan_generate_description') }}</p>
                        </div>

                        <div>
                            <x-input-label for="sex" :value="__('messages.profile_sex')" />
                            <select name="sex" id="sex" class="form-select">
                                <option value="male" @selected(old('sex', $profile?->sex) === 'male')>
                                    {{ __('messages.sex_male') }}
                                </option>
                                <option value="female" @selected(old('sex', $profile?->sex) === 'female')>
                                    {{ __('messages.sex_female') }}
                                </option>
                            </select>
                            @error('sex')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="birth_date" :value="__('messages.profile_birth_date')" />
                            <x-text-input
                                type="date"
                                name="birth_date"
                                id="birth_date"
                                :value="old('birth_date', $profile?->birth_date?->format('Y-m-d'))"
                            />
                            @error('birth_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="height_cm" :value="__('messages.profile_height_cm')" />
                            <x-text-input
                                type="number"
                                step="0.1"
                                name="height_cm"
                                id="height_cm"
                                :value="old('height_cm', $profile?->height_cm)"
                            />
                            @error('height_cm')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="current_weight_kg" :value="__('messages.profile_current_weight_kg')" />
                            <x-text-input
                                type="number"
                                step="0.1"
                                name="current_weight_kg"
                                id="current_weight_kg"
                                :value="old('current_weight_kg', $profile?->current_weight_kg)"
                            />
                            @error('current_weight_kg')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.plan_current_title') }}</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.dashboard_plan_text') }}</p>
                        </div>

                        <div>
                            <x-input-label for="activity_level" :value="__('messages.profile_activity_level')" />
                            <select name="activity_level" id="activity_level" class="form-select">
                                <option value="sedentary" @selected(old('activity_level', $profile?->activity_level) === 'sedentary')>{{ __('messages.activity_sedentary') }}</option>
                                <option value="light" @selected(old('activity_level', $profile?->activity_level) === 'light')>{{ __('messages.activity_light') }}</option>
                                <option value="moderate" @selected(old('activity_level', $profile?->activity_level) === 'moderate')>{{ __('messages.activity_moderate') }}</option>
                                <option value="active" @selected(old('activity_level', $profile?->activity_level) === 'active')>{{ __('messages.activity_active') }}</option>
                                <option value="very_active" @selected(old('activity_level', $profile?->activity_level) === 'very_active')>{{ __('messages.activity_very_active') }}</option>
                            </select>
                            @error('activity_level')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="goal" :value="__('messages.profile_goal')" />
                            <select name="goal" id="goal" class="form-select">
                                <option value="cut" @selected(old('goal', $profile?->goal) === 'cut')>{{ __('messages.goal_cut') }}</option>
                                <option value="bulk" @selected(old('goal', $profile?->goal) === 'bulk')>{{ __('messages.goal_bulk') }}</option>
                            </select>
                            @error('goal')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="intensity" :value="__('messages.profile_intensity')" />
                            <select name="intensity" id="intensity" class="form-select">
                                <option value="mild" @selected(old('intensity', $profile?->intensity) === 'mild')>{{ __('messages.intensity_mild') }}</option>
                                <option value="moderate" @selected(old('intensity', $profile?->intensity) === 'moderate')>{{ __('messages.intensity_moderate') }}</option>
                                <option value="aggressive" @selected(old('intensity', $profile?->intensity) === 'aggressive')>{{ __('messages.intensity_aggressive') }}</option>
                            </select>
                            @error('intensity')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-green-700">{{ __('messages.plan_generate_title') }}</h3>
                            <p class="mt-3 text-sm leading-6 text-slate-600">
                                {{ __('messages.plan_generate_description') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 border-t border-slate-200 pt-6">
                    <button type="submit" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                        {{ __('messages.my_profile_save_button') }}
                    </button>

                    <a href="{{ route('plans.create') }}" class="btn btn-outline rounded-full border-slate-200 px-5 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                        {{ __('messages.nav_generate_plan') }}
                    </a>
                </div>
            </form>
        </section>
    </div>
@endsection
