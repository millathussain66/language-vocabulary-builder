<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Admin\WordController as AdminWordController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Words Routes
Route::middleware('auth')->group(function () {
    Route::get('/words', [WordController::class, 'index'])->name('words.index');
    Route::get('/words/{word}', [WordController::class, 'show'])->name('words.show');
    Route::get('/practice', [WordController::class, 'practice'])->name('words.practice');
});

// Quizzes Routes
Route::middleware('auth')->group(function () {
    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::get('/quizzes/{quiz}/start', [QuizController::class, 'start'])->name('quizzes.start');
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/quiz-results/{attempt}', [QuizController::class, 'results'])->name('quizzes.results');
    Route::get('/quiz-history', [QuizController::class, 'history'])->name('quizzes.history');
});

// Favorites Routes
Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{word}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{word}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::post('/favorites/{word}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Words Management
    Route::resource('words', AdminWordController::class);
    
    // Quizzes Management
    Route::resource('quizzes', AdminQuizController::class);
    
    // Users Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/progress', [AdminUserController::class, 'progress'])->name('users.progress');
});

require __DIR__.'/auth.php';