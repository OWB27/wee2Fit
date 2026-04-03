@extends('layouts.workspace')

@section('content')
    <div class="workspace-content-stack">
        <section>
            <h1 class="workspace-page-title">{{ __('messages.plan_generate_title') }}</h1>
            <p class="workspace-page-description">{{ __('messages.plan_generate_description') }}</p>
        </section>

        <section class="grid gap-4 xl:grid-cols-[minmax(0,1.75fr),340px]">
            <div class="space-y-4">
                <div class="workspace-card">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">Profile Summary</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Your plan will be calculated using this information.</p>
                        </div>

                        <a href="{{ route('my-profile.edit') }}" class="btn btn-outline btn-sm rounded-full border-slate-200 px-4 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                            {{ __('messages.edit') }}
                        </a>
                    </div>

                    <div class="mt-6 grid gap-3 md:grid-cols-3">
                        <div class="rounded-[1.25rem] border border-slate-200 bg-slate-50 p-4">
                            <div class="workspace-stat-label">{{ __('messages.profile_sex') }}</div>
                            <div class="mt-3 text-lg font-semibold text-slate-900">{{ __('messages.sex_' . $profile->sex) }}</div>
                        </div>

                        <div class="rounded-[1.25rem] border border-slate-200 bg-slate-50 p-4">
                            <div class="workspace-stat-label">{{ __('messages.profile_height_cm') }}</div>
                            <div class="mt-3 text-lg font-semibold text-slate-900">{{ $profile->height_cm }}</div>
                        </div>

                        <div class="rounded-[1.25rem] border border-slate-200 bg-slate-50 p-4">
                            <div class="workspace-stat-label">{{ __('messages.profile_current_weight_kg') }}</div>
                            <div class="mt-3 text-lg font-semibold text-slate-900">{{ $profile->current_weight_kg }}</div>
                        </div>

                        <div class="rounded-[1.25rem] border border-slate-200 bg-slate-50 p-4">
                            <div class="workspace-stat-label">{{ __('messages.profile_activity_level') }}</div>
                            <div class="mt-3 text-lg font-semibold text-slate-900">{{ __('messages.activity_' . $profile->activity_level) }}</div>
                        </div>

                        <div class="rounded-[1.25rem] border border-slate-200 bg-slate-50 p-4">
                            <div class="workspace-stat-label">{{ __('messages.profile_goal') }}</div>
                            <div class="mt-3 text-lg font-semibold text-slate-900">{{ __('messages.goal_' . $profile->goal) }}</div>
                        </div>

                        <div class="rounded-[1.25rem] border border-slate-200 bg-slate-50 p-4">
                            <div class="workspace-stat-label">{{ __('messages.profile_intensity') }}</div>
                            <div class="mt-3 text-lg font-semibold text-slate-900">{{ __('messages.intensity_' . $profile->intensity) }}</div>
                        </div>
                    </div>
                </div>

                <div class="workspace-soft-card">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">Ready to Generate Your Plan</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.methodology_paragraph_2') }}</p>
                        </div>

                        <form action="{{ route('plans.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary rounded-full border-0 px-6 normal-case shadow-sm">
                                {{ __('messages.plan_generate_button') }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="workspace-card">
                    <h2 class="text-xl font-semibold text-slate-900">What Will Be Generated</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Your personalized plan includes calorie targets and daily macro guidance.</p>

                    <div class="mt-6 grid gap-3 md:grid-cols-2">
                        <div class="rounded-[1.25rem] border border-slate-200 bg-slate-50 p-4">
                            <div class="font-semibold text-slate-900">{{ __('messages.plan_bmr') }}</div>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Calories burned at complete rest.</p>
                        </div>
                        <div class="rounded-[1.25rem] border border-slate-200 bg-slate-50 p-4">
                            <div class="font-semibold text-slate-900">{{ __('messages.plan_tdee') }}</div>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Estimated total daily energy expenditure.</p>
                        </div>
                        <div class="rounded-[1.25rem] border border-slate-200 bg-slate-50 p-4">
                            <div class="font-semibold text-slate-900">{{ __('messages.plan_target_calories') }}</div>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Daily target adjusted for your goal and intensity.</p>
                        </div>
                        <div class="rounded-[1.25rem] border border-slate-200 bg-slate-50 p-4">
                            <div class="font-semibold text-slate-900">Macro Targets</div>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Protein, carbs, and fat targets for everyday planning.</p>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="space-y-4">
                <div class="workspace-card">
                    <h2 class="text-xl font-semibold text-slate-900">Calculation Preview</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Based on your current profile settings.</p>

                    <div class="mt-6 space-y-4">
                        <div>
                            <div class="flex items-center justify-between text-sm text-slate-600">
                                <span>{{ __('messages.profile_activity_level') }}</span>
                                <span>{{ __('messages.activity_' . $profile->activity_level) }}</span>
                            </div>
                            <div class="workspace-progress-track">
                                <div class="h-2 rounded-full bg-sky-500 w-3/4"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between text-sm text-slate-600">
                                <span>{{ __('messages.profile_goal') }}</span>
                                <span>{{ __('messages.goal_' . $profile->goal) }}</span>
                            </div>
                            <div class="workspace-progress-track">
                                <div class="h-2 rounded-full bg-green-600 w-2/3"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between text-sm text-slate-600">
                                <span>{{ __('messages.profile_intensity') }}</span>
                                <span>{{ __('messages.intensity_' . $profile->intensity) }}</span>
                            </div>
                            <div class="workspace-progress-track">
                                <div class="h-2 rounded-full bg-amber-400 w-1/2"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 rounded-[1.5rem] border border-emerald-100 bg-emerald-50 p-4">
                        <div class="workspace-stat-label">{{ __('messages.plan_generate_title') }}</div>
                        <div class="mt-3 text-4xl font-semibold tracking-tight text-green-700">{{ __('messages.goal_' . $profile->goal) }}</div>
                        <p class="mt-2 text-sm text-slate-600">{{ __('messages.plan_generate_description') }}</p>
                    </div>
                </div>
            </aside>
        </section>
    </div>
@endsection
