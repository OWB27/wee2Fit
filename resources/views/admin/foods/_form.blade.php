@csrf

<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label for="name" class="label">
            <span class="label-text">{{ __('messages.food_name_en') }}</span>
        </label>
        <input
            type="text"
            name="name"
            id="name"
            class="input input-bordered w-full"
            value="{{ old('name', $food->name ?? '') }}"
        >
        @error('name')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="name_zh" class="label">
            <span class="label-text">{{ __('messages.food_name_zh') }}</span>
        </label>
        <input
            type="text"
            name="name_zh"
            id="name_zh"
            class="input input-bordered w-full"
            value="{{ old('name_zh', $food->name_zh ?? '') }}"
        >
        @error('name_zh')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="category" class="label">
            <span class="label-text">{{ __('messages.food_category') }}</span>
        </label>
        <select name="category" id="category" class="select select-bordered w-full">
            @foreach ($categories as $category)
                <option value="{{ $category }}" @selected(old('category', $food->category ?? '') === $category)>
                    {{ __('messages.food_category_' . $category) }}
                </option>
            @endforeach
        </select>
        @error('category')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="calories_per_100g" class="label">
            <span class="label-text">{{ __('messages.food_calories_per_100g') }}</span>
        </label>
        <input
            type="number"
            step="0.1"
            name="calories_per_100g"
            id="calories_per_100g"
            class="input input-bordered w-full"
            value="{{ old('calories_per_100g', $food->calories_per_100g ?? '') }}"
        >
        @error('calories_per_100g')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="protein_per_100g" class="label">
            <span class="label-text">{{ __('messages.plan_protein') }}</span>
        </label>
        <input
            type="number"
            step="0.1"
            name="protein_per_100g"
            id="protein_per_100g"
            class="input input-bordered w-full"
            value="{{ old('protein_per_100g', $food->protein_per_100g ?? '') }}"
        >
        @error('protein_per_100g')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="carbs_per_100g" class="label">
            <span class="label-text">{{ __('messages.plan_carbs') }}</span>
        </label>
        <input
            type="number"
            step="0.1"
            name="carbs_per_100g"
            id="carbs_per_100g"
            class="input input-bordered w-full"
            value="{{ old('carbs_per_100g', $food->carbs_per_100g ?? '') }}"
        >
        @error('carbs_per_100g')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="fat_per_100g" class="label">
            <span class="label-text">{{ __('messages.plan_fat') }}</span>
        </label>
        <input
            type="number"
            step="0.1"
            name="fat_per_100g"
            id="fat_per_100g"
            class="input input-bordered w-full"
            value="{{ old('fat_per_100g', $food->fat_per_100g ?? '') }}"
        >
        @error('fat_per_100g')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="image_path" class="label">
            <span class="label-text">{{ __('messages.food_image_path') }}</span>
        </label>
        <input
            type="text"
            name="image_path"
            id="image_path"
            class="input input-bordered w-full"
            value="{{ old('image_path', $food->image_path ?? '') }}"
        >
        @error('image_path')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="form-control mt-4">
    <label class="label cursor-pointer justify-start gap-3">
        <input
            type="checkbox"
            name="is_verified"
            value="1"
            class="checkbox"
            @checked(old('is_verified', $food->is_verified ?? false))
        >
        <span class="label-text">{{ __('messages.food_verified') }}</span>
    </label>
</div>

<div class="mt-6">
    <button type="submit" class="btn btn-primary">
        {{ __('messages.save') }}
    </button>
</div>