@extends('layouts.workspace')

@section('content')
    @php
        $sexValue = old('sex', $profile?->sex);
        $birthDateValue = old('birth_date', $profile?->birth_date?->format('Y-m-d'));
        $heightValue = old('height_cm', $profile?->height_cm);
        $weightValue = old('current_weight_kg', $profile?->current_weight_kg);
        $activityValue = old('activity_level', $profile?->activity_level);
        $goalValue = old('goal', $profile?->goal);
        $intensityValue = old('intensity', $profile?->intensity);

        $activityFactors = [
            'sedentary' => 1.2,
            'light' => 1.375,
            'moderate' => 1.55,
            'active' => 1.725,
            'very_active' => 1.9,
        ];

        $intensityAdjustments = [
            'mild' => 250,
            'moderate' => 500,
            'aggressive' => 750,
        ];

        $age = $birthDateValue ? \Carbon\Carbon::parse($birthDateValue)->age : null;
        $height = is_numeric($heightValue) ? (float) $heightValue : null;
        $weight = is_numeric($weightValue) ? (float) $weightValue : null;

        $bmr = null;
        if ($age && $height && $weight && in_array($sexValue, ['male', 'female'], true)) {
            $bmr = $sexValue === 'male'
                ? (10 * $weight) + (6.25 * $height) - (5 * $age) + 5
                : (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;
        }

        $tdee = $bmr && isset($activityFactors[$activityValue]) ? $bmr * $activityFactors[$activityValue] : null;
        $targetCalories = null;

        if ($tdee && isset($intensityAdjustments[$intensityValue]) && in_array($goalValue, ['cut', 'bulk'], true)) {
            $targetCalories = $goalValue === 'cut'
                ? $tdee - $intensityAdjustments[$intensityValue]
                : $tdee + $intensityAdjustments[$intensityValue];

            $targetCalories = max(1200, (int) round($targetCalories));
        }
    @endphp

    <div class="workspace-content-stack">
        <section class="flex flex-col gap-3">
            <h1 class="workspace-page-title">{{ __('messages.my_profile_title') }}</h1>
            <p class="workspace-page-description">{{ __('messages.my_profile_description') }}</p>
        </section>

        <form action="{{ route('my-profile.update') }}" method="POST" class="grid gap-6 xl:grid-cols-[minmax(0,1.45fr),340px]">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <section class="workspace-field-shell space-y-6">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.weekly_plan_basic_info') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.plan_generate_description') }}</p>
                    </div>

                    <div class="grid gap-6 lg:grid-cols-2">
                        <div>
                            <x-input-label for="sex" :value="__('messages.profile_sex')" />
                            <div class="grid gap-3 sm:grid-cols-2">
                                <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">
                                    <input type="radio" name="sex" value="male" class="radio radio-sm radio-primary" @checked($sexValue === 'male')>
                                    <span>{{ __('messages.sex_male') }}</span>
                                </label>
                                <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">
                                    <input type="radio" name="sex" value="female" class="radio radio-sm radio-primary" @checked($sexValue === 'female')>
                                    <span>{{ __('messages.sex_female') }}</span>
                                </label>
                            </div>
                            @error('sex')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="birth_date" :value="__('messages.profile_birth_date')" />
                            <x-text-input type="date" name="birth_date" id="birth_date" :value="$birthDateValue" />
                            <p class="mt-2 text-xs text-slate-500">
                                {{ $age ? (app()->getLocale() === 'zh_CN' ? '年龄: ' . $age : 'Age: ' . $age) : __('messages.plan_generate_description') }}
                            </p>
                            @error('birth_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="height_cm" :value="__('messages.profile_height_cm')" />
                            <x-text-input type="number" step="0.1" name="height_cm" id="height_cm" :value="$heightValue" />
                            @error('height_cm')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="current_weight_kg" :value="__('messages.profile_current_weight_kg')" />
                            <x-text-input type="number" step="0.1" name="current_weight_kg" id="current_weight_kg" :value="$weightValue" />
                            @error('current_weight_kg')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>

                <section class="workspace-field-shell space-y-6">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.profile_activity_level') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.dashboard_plan_text') }}</p>
                    </div>

                    <div>
                        <x-input-label for="activity_level" :value="__('messages.profile_activity_level')" />
                        <select name="activity_level" id="activity_level" class="form-select">
                            <option value="sedentary" @selected($activityValue === 'sedentary')>{{ __('messages.activity_sedentary') }}</option>
                            <option value="light" @selected($activityValue === 'light')>{{ __('messages.activity_light') }}</option>
                            <option value="moderate" @selected($activityValue === 'moderate')>{{ __('messages.activity_moderate') }}</option>
                            <option value="active" @selected($activityValue === 'active')>{{ __('messages.activity_active') }}</option>
                            <option value="very_active" @selected($activityValue === 'very_active')>{{ __('messages.activity_very_active') }}</option>
                        </select>
                        @error('activity_level')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="workspace-helper-card">
                        <div class="text-sm font-semibold text-slate-900">{{ __('messages.profile_activity_level') }}</div>
                        <div class="mt-3 grid gap-2 text-sm text-slate-600">
                            <div class="flex items-center justify-between"><span>{{ __('messages.activity_sedentary') }}</span><span>1.2x</span></div>
                            <div class="flex items-center justify-between"><span>{{ __('messages.activity_light') }}</span><span>1.375x</span></div>
                            <div class="flex items-center justify-between"><span>{{ __('messages.activity_moderate') }}</span><span>1.55x</span></div>
                            <div class="flex items-center justify-between"><span>{{ __('messages.activity_active') }}</span><span>1.725x</span></div>
                            <div class="flex items-center justify-between"><span>{{ __('messages.activity_very_active') }}</span><span>1.9x</span></div>
                        </div>
                    </div>
                </section>

                <section class="workspace-field-shell space-y-6">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.profile_goal') }} &amp; {{ __('messages.profile_intensity') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.dashboard_progress_text') }}</p>
                    </div>

                    <div>
                        <x-input-label :value="__('messages.profile_goal')" />
                        <div class="grid gap-3 sm:grid-cols-2">
                            <label class="rounded-2xl border px-4 py-4 text-sm transition {{ $goalValue === 'cut' ? 'border-emerald-400 bg-emerald-50 text-emerald-700' : 'border-slate-200 bg-white text-slate-700' }}">
                                <input type="radio" name="goal" value="cut" class="sr-only" @checked($goalValue === 'cut')>
                                <div class="font-semibold">{{ __('messages.goal_cut') }}</div>
                                <div class="mt-1 text-xs opacity-80">{{ __('messages.plan_target_calories') }}</div>
                            </label>

                            <label class="rounded-2xl border px-4 py-4 text-sm transition {{ $goalValue === 'bulk' ? 'border-amber-300 bg-amber-50 text-amber-700' : 'border-slate-200 bg-white text-slate-700' }}">
                                <input type="radio" name="goal" value="bulk" class="sr-only" @checked($goalValue === 'bulk')>
                                <div class="font-semibold">{{ __('messages.goal_bulk') }}</div>
                                <div class="mt-1 text-xs opacity-80">{{ __('messages.plan_target_calories') }}</div>
                            </label>
                        </div>
                        @error('goal')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-input-label :value="__('messages.profile_intensity')" />
                        <div class="grid gap-3 lg:grid-cols-3">
                            @foreach (['mild', 'moderate', 'aggressive'] as $intensity)
                                <label class="rounded-2xl border px-4 py-4 text-sm transition {{ $intensityValue === $intensity ? 'border-emerald-400 bg-emerald-50 text-emerald-700' : 'border-slate-200 bg-white text-slate-700' }}">
                                    <input type="radio" name="intensity" value="{{ $intensity }}" class="sr-only" @checked($intensityValue === $intensity)>
                                    <div class="font-semibold">{{ __('messages.intensity_' . $intensity) }}</div>
                                    <div class="mt-1 text-xs opacity-80">+/- {{ $intensityAdjustments[$intensity] }} kcal</div>
                                </label>
                            @endforeach
                        </div>
                        @error('intensity')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </section>

                <div class="flex flex-wrap items-center gap-3">
                    <button type="submit" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                        {{ __('messages.my_profile_save_button') }}
                    </button>

                    <a href="{{ route('plans.create') }}" class="btn btn-outline rounded-full border-slate-200 px-5 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                        {{ __('messages.nav_generate_plan') }}
                    </a>
                </div>
            </div>

            <aside class="space-y-4">
                <div class="workspace-soft-card">
                    <div class="text-sm font-semibold text-emerald-700">{{ __('messages.plan_generate_title') }}</div>
                    <div class="mt-4 text-sm text-slate-500">{{ __('messages.plan_target_calories') }}</div>
                    <div class="mt-2 text-4xl font-semibold tracking-tight text-slate-900">
                        {{ $targetCalories ? number_format($targetCalories) . ' kcal' : '--' }}
                    </div>
                    <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.plan_generate_description') }}</p>
                </div>

                <div class="workspace-preview-metric">
                    <div class="text-sm text-slate-500">{{ __('messages.plan_bmr') }}</div>
                    <div class="mt-2 text-2xl font-semibold text-slate-900">
                        {{ $bmr ? number_format($bmr, 0) . ' kcal' : '--' }}
                    </div>
                </div>

                <div class="workspace-preview-metric">
                    <div class="text-sm text-slate-500">{{ __('messages.plan_tdee') }}</div>
                    <div class="mt-2 text-2xl font-semibold text-slate-900">
                        {{ $tdee ? number_format($tdee, 0) . ' kcal' : '--' }}
                    </div>
                </div>

                <div class="workspace-card space-y-4">
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">{{ __('messages.methodology_title') }}</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            Mifflin-St Jeor:
                            <span class="font-medium text-slate-900">10 x kg + 6.25 x cm - 5 x age {{ $sexValue === 'female' ? '- 161' : '+ 5' }}</span>
                        </p>
                    </div>

                    <div class="workspace-helper-card">
                        <div class="text-sm font-semibold text-slate-900">{{ __('messages.my_profile_description') }}</div>
                        <ul class="workspace-info-list mt-3">
                            <li><strong>{{ __('messages.profile_sex') }}</strong> / <strong>{{ __('messages.profile_birth_date') }}</strong></li>
                            <li><strong>{{ __('messages.profile_activity_level') }}</strong> adjusts {{ __('messages.plan_tdee') }}</li>
                            <li><strong>{{ __('messages.profile_goal') }}</strong> and <strong>{{ __('messages.profile_intensity') }}</strong> shape {{ __('messages.plan_target_calories') }}</li>
                        </ul>
                    </div>
                </div>
            </aside>
        </form>
    </div>
@endsection
