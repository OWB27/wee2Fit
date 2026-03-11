@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h1 class="card-title text-3xl">{{ __('messages.my_profile_title') }}</h1>
                <p class="text-base-content/70">
                    {{ __('messages.my_profile_description') }}
                </p>

                @if (session('success'))
                    <div class="alert alert-success mt-4">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('my-profile.update') }}" method="POST" class="space-y-6 mt-6">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label for="sex" class="label">
                                <span class="label-text">{{ __('messages.profile_sex') }}</span>
                            </label>
                            <select name="sex" id="sex" class="select select-bordered w-full">
                                <option value="male" @selected(old('sex', $profile?->sex) === 'male')>
                                    {{ __('messages.sex_male') }}
                                </option>
                                <option value="female" @selected(old('sex', $profile?->sex) === 'female')>
                                    {{ __('messages.sex_female') }}
                                </option>
                            </select>
                            @error('sex')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="birth_date" class="label">
                                <span class="label-text">{{ __('messages.profile_birth_date') }}</span>
                            </label>
                            <input
                                type="date"
                                name="birth_date"
                                id="birth_date"
                                class="input input-bordered w-full"
                                value="{{ old('birth_date', $profile?->birth_date?->format('Y-m-d')) }}"
                            >
                            @error('birth_date')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="height_cm" class="label">
                                <span class="label-text">{{ __('messages.profile_height_cm') }}</span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                name="height_cm"
                                id="height_cm"
                                class="input input-bordered w-full"
                                value="{{ old('height_cm', $profile?->height_cm) }}"
                            >
                            @error('height_cm')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="current_weight_kg" class="label">
                                <span class="label-text">{{ __('messages.profile_current_weight_kg') }}</span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                name="current_weight_kg"
                                id="current_weight_kg"
                                class="input input-bordered w-full"
                                value="{{ old('current_weight_kg', $profile?->current_weight_kg) }}"
                            >
                            @error('current_weight_kg')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="activity_level" class="label">
                                <span class="label-text">{{ __('messages.profile_activity_level') }}</span>
                            </label>
                            <select name="activity_level" id="activity_level" class="select select-bordered w-full">
                                <option value="sedentary" @selected(old('activity_level', $profile?->activity_level) === 'sedentary')>
                                    {{ __('messages.activity_sedentary') }}
                                </option>
                                <option value="light" @selected(old('activity_level', $profile?->activity_level) === 'light')>
                                    {{ __('messages.activity_light') }}
                                </option>
                                <option value="moderate" @selected(old('activity_level', $profile?->activity_level) === 'moderate')>
                                    {{ __('messages.activity_moderate') }}
                                </option>
                                <option value="active" @selected(old('activity_level', $profile?->activity_level) === 'active')>
                                    {{ __('messages.activity_active') }}
                                </option>
                                <option value="very_active" @selected(old('activity_level', $profile?->activity_level) === 'very_active')>
                                    {{ __('messages.activity_very_active') }}
                                </option>
                            </select>
                            @error('activity_level')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="goal" class="label">
                                <span class="label-text">{{ __('messages.profile_goal') }}</span>
                            </label>
                            <select name="goal" id="goal" class="select select-bordered w-full">
                                <option value="cut" @selected(old('goal', $profile?->goal) === 'cut')>
                                    {{ __('messages.goal_cut') }}
                                </option>
                                <option value="bulk" @selected(old('goal', $profile?->goal) === 'bulk')>
                                    {{ __('messages.goal_bulk') }}
                                </option>
                            </select>
                            @error('goal')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="intensity" class="label">
                                <span class="label-text">{{ __('messages.profile_intensity') }}</span>
                            </label>
                            <select name="intensity" id="intensity" class="select select-bordered w-full">
                                <option value="mild" @selected(old('intensity', $profile?->intensity) === 'mild')>
                                    {{ __('messages.intensity_mild') }}
                                </option>
                                <option value="moderate" @selected(old('intensity', $profile?->intensity) === 'moderate')>
                                    {{ __('messages.intensity_moderate') }}
                                </option>
                                <option value="aggressive" @selected(old('intensity', $profile?->intensity) === 'aggressive')>
                                    {{ __('messages.intensity_aggressive') }}
                                </option>
                            </select>
                            @error('intensity')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">
                            {{ __('messages.my_profile_save_button') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection