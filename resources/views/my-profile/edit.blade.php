@extends('layouts.workspace')

@section('content')
    <div class="workspace-content-stack">
        <section class="workspace-page-header-compact">
            <h1 class="workspace-page-title">{{ __('messages.my_profile_title') }}</h1>
            <p class="workspace-page-description">{{ __('messages.my_profile_description') }}</p>
        </section>

        <form action="{{ route('my-profile.update') }}" method="POST" class="layout-main-aside-regular">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <section class="workspace-field-shell form-section">
                    <div>
                        <h2 class="form-section-heading">{{ __('messages.weekly_plan_basic_info') }}</h2>
                        <p class="form-section-description">{{ __('messages.plan_generate_description') }}</p>
                    </div>

                    <div class="grid gap-6 lg:grid-cols-2">
                        <div>
                            <x-input-label for="sex" :value="__('messages.profile_sex')" />
                            <div class="grid gap-3 sm:grid-cols-2">
                            <label class="form-check-card">
                                <input type="radio" name="sex" value="male" class="form-radio" @checked($profileForm['sex'] === 'male')>
                                <span>{{ __('messages.sex_male') }}</span>
                            </label>
                            <label class="form-check-card">
                                <input type="radio" name="sex" value="female" class="form-radio" @checked($profileForm['sex'] === 'female')>
                                <span>{{ __('messages.sex_female') }}</span>
                            </label>
                        </div>
                        @error('sex')
                                <p class="form-error">{{ $message }}</p>
                        @enderror
                        </div>

                        <div>
                            <x-input-label for="birth_date" :value="__('messages.profile_birth_date')" />
                            <x-text-input type="date" name="birth_date" id="birth_date" :value="$profileForm['birth_date']" />
                            <p class="form-help">
                                @if ($profilePreview['age'])
                                    {{ __('messages.profile_age_label') }}: {{ $profilePreview['age'] }}
                                @else
                                    {{ __('messages.plan_generate_description') }}
                                @endif
                            </p>
                            @error('birth_date')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="height_cm" :value="__('messages.profile_height_cm')" />
                            <x-text-input type="number" step="0.1" name="height_cm" id="height_cm" :value="$profileForm['height_cm']" />
                            @error('height_cm')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="current_weight_kg" :value="__('messages.profile_current_weight_kg')" />
                            <x-text-input type="number" step="0.1" name="current_weight_kg" id="current_weight_kg" :value="$profileForm['current_weight_kg']" />
                            @error('current_weight_kg')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>

                <section class="workspace-field-shell form-section">
                    <div>
                        <h2 class="form-section-heading">{{ __('messages.profile_activity_level') }}</h2>
                        <p class="form-section-description">{{ __('messages.dashboard_plan_text') }}</p>
                    </div>

                    <div>
                        <x-input-label for="activity_level" :value="__('messages.profile_activity_level')" />
                        <select name="activity_level" id="activity_level" class="form-select">
                            <option value="sedentary" @selected($profileForm['activity_level'] === 'sedentary')>{{ __('messages.activity_sedentary') }}</option>
                            <option value="light" @selected($profileForm['activity_level'] === 'light')>{{ __('messages.activity_light') }}</option>
                            <option value="moderate" @selected($profileForm['activity_level'] === 'moderate')>{{ __('messages.activity_moderate') }}</option>
                            <option value="active" @selected($profileForm['activity_level'] === 'active')>{{ __('messages.activity_active') }}</option>
                            <option value="very_active" @selected($profileForm['activity_level'] === 'very_active')>{{ __('messages.activity_very_active') }}</option>
                        </select>
                        @error('activity_level')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="workspace-helper-card">
                        <div class="text-sm font-semibold text-slate-900">{{ __('messages.profile_activity_level') }}</div>
                        <div class="mt-3 grid gap-2 text-sm text-slate-600">
                            <div class="info-row"><span class="info-row-label">{{ __('messages.activity_sedentary') }}</span><span class="info-row-value">{{ $profileOptions['activity_factors']['sedentary'] }}x</span></div>
                            <div class="info-row"><span class="info-row-label">{{ __('messages.activity_light') }}</span><span class="info-row-value">{{ $profileOptions['activity_factors']['light'] }}x</span></div>
                            <div class="info-row"><span class="info-row-label">{{ __('messages.activity_moderate') }}</span><span class="info-row-value">{{ $profileOptions['activity_factors']['moderate'] }}x</span></div>
                            <div class="info-row"><span class="info-row-label">{{ __('messages.activity_active') }}</span><span class="info-row-value">{{ $profileOptions['activity_factors']['active'] }}x</span></div>
                            <div class="info-row"><span class="info-row-label">{{ __('messages.activity_very_active') }}</span><span class="info-row-value">{{ $profileOptions['activity_factors']['very_active'] }}x</span></div>
                        </div>
                    </div>
                </section>

                <section class="workspace-field-shell form-section">
                    <div>
                        <h2 class="form-section-heading">{{ __('messages.profile_goal') }} &amp; {{ __('messages.profile_intensity') }}</h2>
                        <p class="form-section-description">{{ __('messages.dashboard_progress_text') }}</p>
                    </div>

                    <div>
                        <x-input-label :value="__('messages.profile_goal')" />
                        <div class="grid gap-3 sm:grid-cols-2">
                            <label class="profile-choice-card profile-choice-card-cut">
                                <input type="radio" name="goal" value="cut" class="sr-only" @checked($profileForm['goal'] === 'cut')>
                                <div class="profile-choice-panel">
                                    <div class="font-semibold">{{ __('messages.goal_cut') }}</div>
                                    <div class="mt-1 text-xs opacity-80">{{ __('messages.plan_target_calories') }}</div>
                                </div>
                            </label>

                            <label class="profile-choice-card profile-choice-card-bulk">
                                <input type="radio" name="goal" value="bulk" class="sr-only" @checked($profileForm['goal'] === 'bulk')>
                                <div class="profile-choice-panel">
                                    <div class="font-semibold">{{ __('messages.goal_bulk') }}</div>
                                    <div class="mt-1 text-xs opacity-80">{{ __('messages.plan_target_calories') }}</div>
                                </div>
                            </label>
                        </div>
                        @error('goal')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-input-label :value="__('messages.profile_intensity')" />
                        <div class="grid gap-3 lg:grid-cols-3">
                            <label class="profile-choice-card profile-choice-card-mild">
                                <input type="radio" name="intensity" value="mild" class="sr-only" @checked($profileForm['intensity'] === 'mild')>
                                <div class="profile-choice-panel">
                                    <div class="font-semibold">{{ __('messages.intensity_mild') }}</div>
                                    <div class="mt-1 text-xs opacity-80">+/- {{ $profileOptions['intensity_adjustments']['mild'] }} kcal</div>
                                </div>
                            </label>

                            <label class="profile-choice-card profile-choice-card-moderate">
                                <input type="radio" name="intensity" value="moderate" class="sr-only" @checked($profileForm['intensity'] === 'moderate')>
                                <div class="profile-choice-panel">
                                    <div class="font-semibold">{{ __('messages.intensity_moderate') }}</div>
                                    <div class="mt-1 text-xs opacity-80">+/- {{ $profileOptions['intensity_adjustments']['moderate'] }} kcal</div>
                                </div>
                            </label>

                            <label class="profile-choice-card profile-choice-card-aggressive">
                                <input type="radio" name="intensity" value="aggressive" class="sr-only" @checked($profileForm['intensity'] === 'aggressive')>
                                <div class="profile-choice-panel">
                                    <div class="font-semibold">{{ __('messages.intensity_aggressive') }}</div>
                                    <div class="mt-1 text-xs opacity-80">+/- {{ $profileOptions['intensity_adjustments']['aggressive'] }} kcal</div>
                                </div>
                            </label>
                        </div>
                        @error('intensity')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </section>

                <div class="form-actions">
                    <button type="submit" class="btn-ui btn-ui-md btn-ui-primary">
                        {{ __('messages.my_profile_save_button') }}
                    </button>

                    <a href="{{ route('plans.current') }}" class="btn-ui btn-ui-md btn-ui-secondary">
                        {{ __('messages.nav_plan') }}
                    </a>
                </div>
            </div>

            <aside class="space-y-4">
                <div class="workspace-soft-card">
                    <div class="text-sm font-semibold text-emerald-700">{{ __('messages.plan_generate_title') }}</div>
                    <div class="key-stat-label mt-4">{{ __('messages.plan_target_calories') }}</div>
                    <div class="mt-2 text-4xl font-semibold tracking-tight text-slate-900">
                        {{ $profilePreview['target_calories'] ? number_format($profilePreview['target_calories']) . ' kcal' : '--' }}
                    </div>
                    <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.plan_generate_description') }}</p>
                </div>

                <div class="workspace-preview-metric">
                    <div class="key-stat-label">{{ __('messages.plan_bmr') }}</div>
                    <div class="mt-2 text-2xl font-semibold text-slate-900">
                        {{ $profilePreview['bmr'] ? number_format($profilePreview['bmr'], 0) . ' kcal' : '--' }}
                    </div>
                </div>

                <div class="workspace-preview-metric">
                    <div class="key-stat-label">{{ __('messages.plan_tdee') }}</div>
                    <div class="mt-2 text-2xl font-semibold text-slate-900">
                        {{ $profilePreview['tdee'] ? number_format($profilePreview['tdee'], 0) . ' kcal' : '--' }}
                    </div>
                </div>
            </aside>
        </form>
    </div>
@endsection
