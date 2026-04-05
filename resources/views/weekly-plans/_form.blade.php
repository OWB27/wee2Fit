@csrf

<div class="space-y-5">
    <div>
        <x-input-label for="title" :value="__('messages.weekly_plan_title')" />
        <x-text-input
            type="text"
            name="title"
            id="title"
            :value="old('title', $weeklyPlan->title ?? '')"
        />
        @error('title')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <x-input-label for="week_start_date" :value="__('messages.weekly_plan_week_start_date')" />
        <x-text-input
            type="date"
            name="week_start_date"
            id="week_start_date"
            :value="old('week_start_date', isset($weeklyPlan) && $weeklyPlan->week_start_date ? $weeklyPlan->week_start_date->format('Y-m-d') : '')"
        />
        @error('week_start_date')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <x-input-label for="note" :value="__('messages.weekly_plan_note')" />
        <textarea
            name="note"
            id="note"
            rows="4"
            class="form-textarea"
        >{{ old('note', $weeklyPlan->note ?? '') }}</textarea>
        @error('note')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">
        <input
            type="checkbox"
            name="is_finalized"
            value="1"
            class="form-checkbox"
            @checked(old('is_finalized', $weeklyPlan->is_finalized ?? false))
        >
        <span>{{ __('messages.weekly_plan_is_finalized') }}</span>
    </label>

</div>
