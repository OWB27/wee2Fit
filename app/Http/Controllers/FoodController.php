<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FoodController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');

        $foods = Food::query()
            ->when($category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('foods.index', [
            'foods' => $foods,
            'category' => $category,
            'categories' => Food::CATEGORY_OPTIONS,
        ]);
    }

    public function show(Food $food): View
    {
        return view('foods.show', [
            'food' => $food,
        ]);
    }
}