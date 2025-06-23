<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\CommentController;

// Redirect root to dashboard
Route::get('/', fn () => redirect()->route('tasks.dashboard'));

// All routes that require authentication
Route::middleware(['auth'])->group(function () {

    // ================================
    // TASK ROUTES
    // ================================
    Route::get('/dashboard', [TaskController::class, 'dashboard'])->name('tasks.dashboard');
    Route::get('/tasks/calendar', [TaskController::class, 'calendar'])->name('tasks.calendar');

    Route::resource('tasks', TaskController::class)->except(['show']);
    Route::get('/tasks/{task}', [TaskController::class, 'show'])
        ->where('task', '[0-9]+')
        ->name('tasks.show');
    Route::patch('/tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus'])->name('tasks.toggleStatus');


    // ================================
    // CATEGORY ROUTES
    // ================================
    Route::resource('categories', CategoryController::class)->only(['index', 'create', 'store']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');


    // ================================
    // PROFILE ROUTES
    // ================================
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });


    // ================================
    // FORUM ROUTES
    // ================================
    Route::prefix('forums')->name('forums.')->group(function () {
        Route::get('/', [ForumController::class, 'index'])->name('index');
        Route::get('/create', [ForumController::class, 'create'])->name('create');
        Route::post('/', [ForumController::class, 'store'])->name('store');
        Route::get('/list', [ForumController::class, 'list'])->name('list');
        Route::get('/search', [ForumController::class, 'search'])->name('search');
        Route::get('/mine', [ForumController::class, 'myForums'])->name('mine');
        Route::delete('/{forum}/leave', [ForumController::class, 'leave'])->name('leave');
        Route::post('/{id}/join', [ForumController::class, 'join'])->name('join');
        Route::get('/{forum}/members', [ForumController::class, 'members'])->name('members');
        Route::delete('/{forum}/members/{user}', [ForumController::class, 'kick'])->name('kick');
        Route::get('/{forum}/edit', [ForumController::class, 'edit'])->name('edit');
        Route::put('/{forum}', [ForumController::class, 'update'])->name('update');
        Route::get('/{id}', [ForumController::class, 'show'])->where('id', '[0-9]+')->name('show');
    });


    // ================================
    // COMMENT ROUTES
    // ================================
    Route::prefix('comments')->name('comments.')->group(function () {
        Route::post('/', [CommentController::class, 'store'])->name('store');
        Route::delete('/{id}', [CommentController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/edit', [CommentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CommentController::class, 'update'])->name('update');
        Route::post('/{comment}/reply', [CommentController::class, 'reply'])->name('reply');
    });


    // ================================
    // NOTIFICATIONS
    // ================================
    Route::get('/notifications/mark-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    })->name('notifications.read');

});


// ================================
// AUTH ROUTES (Login/Register/...)
// ================================
require __DIR__.'/auth.php';
