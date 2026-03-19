@csrf

<div class="space-y-4">
    <div>
        <label for="title" class="label">
            <span class="label-text">{{ __('messages.weekly_plan_title') }}</span>
        </label>
        <input
            type="text"
            name="title"
            id="title"
            class="input input-bordered w-full"
            value="{{ old('title', $weeklyPlan->title ?? '') }}"
        >
        @error('title')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="week_start_date" class="label">
            <span class="label-text">{{ __('messages.weekly_plan_week_start_date') }}</span>
        </label>
        <input
            type="date"
            name="week_start_date"
            id="week_start_date"
            class="input input-bordered w-full"
            value="{{ old('week_start_date', isset($weeklyPlan) && $weeklyPlan->week_start_date ? $weeklyPlan->week_start_date->format('Y-m-d') : '') }}"
        >
        @error('week_start_date')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="note" class="label">
            <span class="label-text">{{ __('messages.weekly_plan_note') }}</span>
        </label>
        <textarea
            name="note"
            id="note"
            rows="4"
            class="textarea textarea-bordered w-full"
        >{{ old('note', $weeklyPlan->note ?? '') }}</textarea>
        @error('note')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-control">
        <label class="label cursor-pointer justify-start gap-3">
            <input
                type="checkbox"
                name="is_finalized"
                value="1"
                class="checkbox"
                @checked(old('is_finalized', $weeklyPlan->is_finalized ?? false))
            >
            <span class="label-text">{{ __('messages.weekly_plan_is_finalized') }}</span>
        </label>
    </div>

    <button type="submit" class="btn btn-primary">
        {{ __('messages.save') }}
    </button>
</div>