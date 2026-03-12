<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\MethodologyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MyProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminFoodController;
use App\Http\Controllers\FoodController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/methodology', [MethodologyController::class, 'index'])->name('methodology');
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');
Route::get('/foods', [FoodController::class, 'index'])->name('foods.index');
Route::get('/foods/{food}', [FoodController::class, 'show'])->name('foods.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Breeze 自带的账号资料管理
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 业务 Profile
    Route::get('/my-profile', [MyProfileController::class, 'edit'])->name('my-profile.edit');
    Route::put('/my-profile', [MyProfileController::class, 'update'])->name('my-profile.update');

    Route::get('/plans/generate', [PlanController::class, 'create'])->name('plans.create');
    Route::post('/plans/generate', [PlanController::class, 'store'])->name('plans.store');
    Route::get('/plans/current', [PlanController::class, 'showCurrent'])->name('plans.current');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/foods', [AdminFoodController::class, 'index'])->name('foods.index');
    Route::get('/foods/create', [AdminFoodController::class, 'create'])->name('foods.create');
    Route::post('/foods', [AdminFoodController::class, 'store'])->name('foods.store');
    Route::get('/foods/{food}/edit', [AdminFoodController::class, 'edit'])->name('foods.edit');
    Route::put('/foods/{food}', [AdminFoodController::class, 'update'])->name('foods.update');
    Route::delete('/foods/{food}', [AdminFoodController::class, 'destroy'])->name('foods.destroy');
});

require __DIR__.'/auth.php';
