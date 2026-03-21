<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminFoodController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\MethodologyController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BodyMetricController;
use App\Http\Controllers\WeeklyPlanController;
use App\Http\Controllers\WeeklyPlanFoodController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/methodology', [MethodologyController::class, 'index'])->name('methodology');
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/foods', [FoodController::class, 'index'])->name('foods.index');
Route::get('/foods/{food}', [FoodController::class, 'show'])->name('foods.show');

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Breeze 账号资料
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 业务资料
    Route::get('/my-profile', [MyProfileController::class, 'edit'])->name('my-profile.edit');
    Route::put('/my-profile', [MyProfileController::class, 'update'])->name('my-profile.update');

    // Plans
    Route::get('/plans/generate', [PlanController::class, 'create'])->name('plans.create');
    Route::post('/plans/generate', [PlanController::class, 'store'])->name('plans.store');
    Route::get('/plans/current', [PlanController::class, 'showCurrent'])->name('plans.current');

    Route::get('/progress', [BodyMetricController::class, 'index'])->name('progress.index');
    Route::post('/progress', [BodyMetricController::class, 'store'])->name('progress.store');
    Route::delete('/progress/{bodyMetric}', [BodyMetricController::class, 'destroy'])->name('progress.destroy');

    Route::get('/weekly-plans', [WeeklyPlanController::class, 'index'])->name('weekly-plans.index');
    Route::get('/weekly-plans/create', [WeeklyPlanController::class, 'create'])->name('weekly-plans.create');
    Route::post('/weekly-plans', [WeeklyPlanController::class, 'store'])->name('weekly-plans.store');
    Route::get('/weekly-plans/{weeklyPlan}', [WeeklyPlanController::class, 'show'])->name('weekly-plans.show');
    Route::put('/weekly-plans/{weeklyPlan}', [WeeklyPlanController::class, 'update'])->name('weekly-plans.update');

    Route::post('/weekly-plans/{weeklyPlan}/foods', [WeeklyPlanFoodController::class, 'store'])->name('weekly-plan-foods.store');
    Route::delete('/weekly-plan-foods/{weeklyPlanFood}', [WeeklyPlanFoodController::class, 'destroy'])->name('weekly-plan-foods.destroy');

});

Route::middleware(['auth', 'active', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/foods', [AdminFoodController::class, 'index'])->name('foods.index');
    Route::get('/foods/create', [AdminFoodController::class, 'create'])->name('foods.create');
    Route::post('/foods', [AdminFoodController::class, 'store'])->name('foods.store');
    Route::get('/foods/{food}/edit', [AdminFoodController::class, 'edit'])->name('foods.edit');
    Route::put('/foods/{food}', [AdminFoodController::class, 'update'])->name('foods.update');
    Route::delete('/foods/{food}', [AdminFoodController::class, 'destroy'])->name('foods.destroy');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggle-active');
});

require __DIR__.'/auth.php';