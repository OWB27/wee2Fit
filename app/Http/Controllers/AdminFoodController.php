<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use App\Models\Food;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminFoodController extends Controller
{
    public function index(): View
    {
        $foods = Food::query()
            ->latest()
            ->paginate(15);

        return view('admin.foods.index', [
            'foods' => $foods,
        ]);
    }

    public function create(): View
    {
        return view('admin.foods.create', [
            'categories' => Food::CATEGORY_OPTIONS,
        ]);
    }

    public function store(StoreFoodRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_verified'] = $request->boolean('is_verified');

        Food::create($data);

        return redirect()
            ->route('admin.foods.index')
            ->with('success', __('messages.admin_food_created'));
    }

    public function edit(Food $food): View
    {
        return view('admin.foods.edit', [
            'food' => $food,
            'categories' => Food::CATEGORY_OPTIONS,
        ]);
    }

    public function update(UpdateFoodRequest $request, Food $food): RedirectResponse
    {
        $data = $request->validated();
        $data['is_verified'] = $request->boolean('is_verified');

        $food->update($data);

        return redirect()
            ->route('admin.foods.index')
            ->with('success', __('messages.admin_food_updated'));
    }

    public function destroy(Food $food): RedirectResponse
    {
        $food->delete();

        return redirect()
            ->route('admin.foods.index')
            ->with('success', __('messages.admin_food_deleted'));
    }
}