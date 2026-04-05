@csrf

<div class="grid gap-4 md:grid-cols-2">
    <div>
        <x-input-label for="name" :value="__('messages.food_name_en')" />
        <x-text-input
            type="text"
            name="name"
            id="name"
            :value="old('name', $food->name ?? '')"
        />
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <x-input-label for="name_zh" :value="__('messages.food_name_zh')" />
        <x-text-input
            type="text"
            name="name_zh"
            id="name_zh"
            :value="old('name_zh', $food->name_zh ?? '')"
        />
        @error('name_zh')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <x-input-label for="category" :value="__('messages.food_category')" />
        <select name="category" id="category" class="form-select">
            @foreach ($categories as $category)
                <option value="{{ $category }}" @selected(old('category', $food->category ?? '') === $category)>
                    {{ __('messages.food_category_' . $category) }}
                </option>
            @endforeach
        </select>
        @error('category')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <x-input-label for="calories_per_100g" :value="__('messages.food_calories_per_100g')" />
        <x-text-input
            type="number"
            step="0.1"
            name="calories_per_100g"
            id="calories_per_100g"
            :value="old('calories_per_100g', $food->calories_per_100g ?? '')"
        />
        @error('calories_per_100g')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <x-input-label for="protein_per_100g" :value="__('messages.plan_protein')" />
        <x-text-input
            type="number"
            step="0.1"
            name="protein_per_100g"
            id="protein_per_100g"
            :value="old('protein_per_100g', $food->protein_per_100g ?? '')"
        />
        @error('protein_per_100g')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <x-input-label for="carbs_per_100g" :value="__('messages.plan_carbs')" />
        <x-text-input
            type="number"
            step="0.1"
            name="carbs_per_100g"
            id="carbs_per_100g"
            :value="old('carbs_per_100g', $food->carbs_per_100g ?? '')"
        />
        @error('carbs_per_100g')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <x-input-label for="fat_per_100g" :value="__('messages.plan_fat')" />
        <x-text-input
            type="number"
            step="0.1"
            name="fat_per_100g"
            id="fat_per_100g"
            :value="old('fat_per_100g', $food->fat_per_100g ?? '')"
        />
        @error('fat_per_100g')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <x-input-label for="image" :value="__('messages.food_image_path')" />
        <input type="file" name="image" id="image" class="form-file">
        @error('image')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror

        <p class="mt-2 text-sm text-slate-500">
            {{ __('messages.food_image_upload_hint') }}
        </p>

        @if (isset($food) && $food->imageUrl())
            <div class="mt-4 overflow-hidden rounded-3xl border border-slate-200 bg-slate-50">
                <img src="{{ $food->imageUrl() }}" alt="{{ $food->displayName() }}" class="h-48 w-full object-cover">
            </div>
        @endif
    </div>
</div>

<div class="mt-4">
    <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">
        <input
            type="checkbox"
            name="is_verified"
            value="1"
            class="form-checkbox"
            @checked(old('is_verified', $food->is_verified ?? false))
        >
        <span>{{ __('messages.food_verified') }}</span>
    </label>
</div>

<div class="mt-6">
    <button type="submit" class="btn-ui btn-ui-md btn-ui-primary">
        {{ __('messages.save') }}
    </button>
</div>
