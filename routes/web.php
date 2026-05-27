<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DailyViewController;
use App\Http\Controllers\ReportController;

// Redirect homepage to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Protected routes - must be logged in
Route::middleware(['auth'])->group(function () {

    // Dashboard
Route::get('/dashboard', function () {
    $todayActivities = \App\Models\Activity::whereDate(
            'activity_date', today()
        )->count();

    $todayDone = \App\Models\Activity::whereDate(
            'activity_date', today()
        )->where('status', 'done')->count();

    $todayPending = \App\Models\Activity::whereDate(
            'activity_date', today()
        )->where('status', 'pending')->count();

    $totalActivities = \App\Models\Activity::count();

    $recentActivities = \App\Models\Activity::with('user')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    $recentLogs = \App\Models\ActivityLog::with(['user', 'activity'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    return view('dashboard', compact(
        'todayActivities',
        'todayDone',
        'todayPending',
        'totalActivities',
        'recentActivities',
        'recentLogs'
    ));
})->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Activities routes
    Route::resource('activities', ActivityController::class);

    // Daily View route
    Route::get('/daily', [DailyViewController::class, 'index'])
        ->name('daily.index');

    // Reports route
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

});

// Breeze auth routes
require __DIR__.'/auth.php';