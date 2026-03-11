<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\MethodologyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MyProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/methodology', [MethodologyController::class, 'index'])->name('methodology');
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

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

require __DIR__.'/auth.php';
