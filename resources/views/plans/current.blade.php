@extends('layouts.workspace')

@section('content')
    <div class="workspace-content-stack">
        <section>
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <h1 class="workspace-page-title">{{ __('messages.plan_current_title') }}</h1>
                    <p class="workspace-page-description">{{ app()->getLocale() === 'zh_CN' ? '这是你当前正在使用的营养计划。' : 'Your active nutrition plan.' }}</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('my-profile.edit') }}" class="btn btn-outline rounded-full border-slate-200 px-5 normal-case text-slate-700 hover:border-slate-300 hover:bg-slate-50">
                        {{ __('messages.edit') }} {{ __('messages.nav_my_profile') }}
                    </a>
                    <a href="{{ route('plans.create') }}" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                        {{ __('messages.plan_regenerate_button') }}
                    </a>
                </div>
            </div>
        </section>

        <section class="workspace-soft-card">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <div class="workspace-chip">{{ __('messages.plan_goal') }}: {{ __('messages.goal_' . $plan->goal) }}</div>
                    <div class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.plan_generated_success') }}</div>
                </div>

                <div class="text-sm text-slate-500">
                    {{ __('messages.profile_activity_level') }}: {{ __('messages.activity_' . $plan->activity_level) }}
                </div>
            </div>
        </section>

        <section class="grid gap-4 xl:grid-cols-4">
            <div class="workspace-stat-card">
                <div class="workspace-stat-label">{{ __('messages.plan_bmr') }}</div>
                <div class="workspace-stat-value">{{ $plan->bmr }}</div>
                <p class="mt-2 text-sm text-slate-600">{{ app()->getLocale() === 'zh_CN' ? '静息状态下每日热量' : 'kcal / day at rest' }}</p>
            </div>

            <div class="workspace-stat-card">
                <div class="workspace-stat-label">{{ __('messages.profile_activity_level') }}</div>
                <div class="workspace-stat-value text-3xl">{{ __('messages.activity_' . $plan->activity_level) }}</div>
                <p class="mt-2 text-sm text-slate-600">{{ __('messages.plan_tdee') }}</p>
            </div>

            <div class="workspace-stat-card">
                <div class="workspace-stat-label">{{ __('messages.plan_tdee') }}</div>
                <div class="workspace-stat-value">{{ $plan->tdee }}</div>
                <p class="mt-2 text-sm text-slate-600">{{ app()->getLocale() === 'zh_CN' ? '估算的每日总消耗' : 'Estimated daily expenditure' }}</p>
            </div>

            <div class="workspace-soft-card">
                <div class="workspace-stat-label">{{ __('messages.plan_target_calories') }}</div>
                <div class="workspace-stat-value text-green-700">{{ $plan->target_calories }}</div>
                <p class="mt-2 text-sm text-slate-600">{{ __('messages.intensity_' . $plan->intensity) }}</p>
            </div>
        </section>

        <section class="workspace-card">
            <h2 class="text-xl font-semibold text-slate-900">{{ app()->getLocale() === 'zh_CN' ? '宏量营养目标' : 'Macro Targets' }}</h2>
            <p class="mt-2 text-sm leading-6 text-slate-600">{{ app()->getLocale() === 'zh_CN' ? '基于你当前目标的每日宏量营养分配。' : 'Daily macronutrient distribution based on your current goal.' }}</p>

            <div class="mt-6 grid gap-6 md:grid-cols-3">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-slate-900">{{ __('messages.plan_protein') }}</span>
                        <span class="text-sm text-slate-500">{{ $plan->protein_g }} g</span>
                    </div>
                    <div class="workspace-progress-track">
                        <div class="h-2 rounded-full bg-rose-500 w-4/5"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-slate-900">{{ __('messages.plan_carbs') }}</span>
                        <span class="text-sm text-slate-500">{{ $plan->carbs_g }} g</span>
                    </div>
                    <div class="workspace-progress-track">
                        <div class="h-2 rounded-full bg-amber-400 w-3/4"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-slate-900">{{ __('messages.plan_fat') }}</span>
                        <span class="text-sm text-slate-500">{{ $plan->fat_g }} g</span>
                    </div>
                    <div class="workspace-progress-track">
                        <div class="h-2 rounded-full bg-sky-500 w-2/5"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 xl:grid-cols-[minmax(0,1.4fr),minmax(0,1fr)]">
            <div class="workspace-card">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-slate-900">{{ app()->getLocale() === 'zh_CN' ? '用于计算的资料' : 'Profile Used for Calculation' }}</h2>
                    <a href="{{ route('my-profile.edit') }}" class="text-sm font-medium text-green-700 hover:text-green-800">{{ app()->getLocale() === 'zh_CN' ? '更新资料' : 'Update Profile' }}</a>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-4">
                    <div>
                        <div class="workspace-stat-label">{{ __('messages.profile_sex') }}</div>
                        <div class="mt-2 text-lg font-semibold text-slate-900">{{ __('messages.sex_' . $plan->sex) }}</div>
                    </div>
                    <div>
                        <div class="workspace-stat-label">{{ app()->getLocale() === 'zh_CN' ? '年龄' : 'Age' }}</div>
                        <div class="mt-2 text-lg font-semibold text-slate-900">{{ $plan->age }}</div>
                    </div>
                    <div>
                        <div class="workspace-stat-label">{{ __('messages.profile_height_cm') }}</div>
                        <div class="mt-2 text-lg font-semibold text-slate-900">{{ $plan->height_cm }}</div>
                    </div>
                    <div>
                        <div class="workspace-stat-label">{{ __('messages.profile_current_weight_kg') }}</div>
                        <div class="mt-2 text-lg font-semibold text-slate-900">{{ $plan->weight_kg }}</div>
                    </div>
                </div>
            </div>

            <div class="workspace-card">
                <h2 class="text-xl font-semibold text-slate-900">{{ app()->getLocale() === 'zh_CN' ? '这个计划如何计算' : 'How This Plan Was Calculated' }}</h2>
                <div class="mt-5 space-y-3">
                    <details class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3" open>
                        <summary class="cursor-pointer font-medium text-slate-900">{{ app()->getLocale() === 'zh_CN' ? '步骤 1' : 'Step 1' }}: {{ __('messages.plan_bmr') }}</summary>
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ app()->getLocale() === 'zh_CN' ? '基础热量由你的年龄、性别、身高和体重估算。' : 'Baseline calories are estimated from your age, sex, height, and weight.' }}</p>
                    </details>

                    <details class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <summary class="cursor-pointer font-medium text-slate-900">{{ app()->getLocale() === 'zh_CN' ? '步骤 2' : 'Step 2' }}: {{ __('messages.plan_tdee') }}</summary>
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ app()->getLocale() === 'zh_CN' ? '活动水平用于估算每日总能量消耗。' : 'Your activity level is used to estimate total daily energy expenditure.' }}</p>
                    </details>

                    <details class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <summary class="cursor-pointer font-medium text-slate-900">{{ app()->getLocale() === 'zh_CN' ? '步骤 3' : 'Step 3' }}: {{ __('messages.plan_target_calories') }}</summary>
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ app()->getLocale() === 'zh_CN' ? '目标和强度会让目标热量高于或低于 TDEE。' : 'Goal and intensity adjust the target calories above or below TDEE.' }}</p>
                    </details>
                </div>
            </div>
        </section>

        <section class="workspace-card">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">{{ app()->getLocale() === 'zh_CN' ? '准备开始规划你的饮食了吗？' : 'Ready to start planning your meals?' }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ app()->getLocale() === 'zh_CN' ? '使用这些目标来创建你的每周食谱。' : 'Use these targets to create your weekly meal plan.' }}</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('weekly-plans.index') }}" class="btn btn-outline rounded-full border-slate-200 px-5 normal-case text-slate-700 hover:border-slate-300 hover:bg-slate-50">
                        {{ __('messages.weekly_plan_open_planner') }}
                    </a>
                    <a href="{{ route('weekly-plans.create') }}" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                        {{ __('messages.weekly_plan_create') }}
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
