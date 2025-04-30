<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DietController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\WorkoutGuideController;

Route::get('/workout-guide', [WorkoutGuideController::class, 'index'])->name('workout-guide.index');


Route::resource('progress', ProgressController::class)->middleware('auth');

Route::resource('workouts', WorkoutController::class)->except(['show']);

Route::middleware(['auth'])->group(function () {
    Route::get('/diet', [DietController::class, 'index'])->name('diet.index');
    Route::get('/diet/create', [DietController::class, 'create'])->name('diet.create');
    Route::post('/diet', [DietController::class, 'store'])->name('diet.store');
    Route::get('/diet/{meal}/edit', [DietController::class, 'edit'])->name('diet.edit');
    Route::put('/diet/{meal}', [DietController::class, 'update'])->name('diet.update');
    Route::delete('/diet/{meal}', [DietController::class, 'destroy'])->name('diet.destroy');
});

Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
