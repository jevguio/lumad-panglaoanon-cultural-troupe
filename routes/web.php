<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CostumeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventHighlightsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('dashboard');
});

// Public routes

Route::middleware(['guest'])->group(function () {
    Auth::routes();
    Route::get('/login', [DashboardController::class, 'loginShow'])->name('login');
});
// Protected routes
Route::middleware(['auth'])->group(function () {
    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/event-schedule', [EventController::class, 'index'])->name('events.index');

    Route::post('/events/{event}/status', [EventController::class, 'updateStatus'])->name('events.updateStatus');

    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events', [EventController::class, 'show'])->name('events.create');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update'); // update
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy'); // delete

    Route::post('/events/{event}/performers/{user}/availability', [EventController::class, 'updatePerformerAvailability'])
        ->name('performer.availability.update')
        ->middleware('auth');

    Route::get('/event-availability-status', [EventController::class, 'availability'])->name('event.availability');
    Route::get('/my-schedule', [EventController::class, 'mySchedule'])->name('my.schedule');

    Route::get('/performer/availability', [EventController::class, 'performerAvailability'])
        ->name('performer.availability')
        ->middleware('auth');
    Route::get('/performer/history', [EventController::class, 'performerHistory'])
        ->name('performer.history')
        ->middleware('auth');
    Route::get('/performer/attendance', [AttendanceController::class, 'index'])->name('performer.attendance');
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::resource('costumes', CostumeController::class);
    Route::get('/costumes', [CostumeController::class, 'index'])->name('costume.status');
    Route::get('/manage-costume', [CostumeController::class, 'index'])->name('manage-costume');
    Route::get('/costume/{costume}/edit', [CostumeController::class, 'edit'])->name('edit-costume');
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/{event}/{user}', [AttendanceController::class, 'update'])->name('attendance.update');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/manage/events/hignlights', [EventHighlightsController::class, 'index'])->name('manage.events.highlights');

    Route::get('/view/events/hignlights', [EventHighlightsController::class, 'index'])->name('view.events.highlights');
    Route::get('/view/events/history', [EventHighlightsController::class, 'index'])->name('view.events.history');

    Route::post('/event-highlights', [EventHighlightsController::class, 'store'])->name('highlights.store');
    Route::get('/event-highlights/{id}', [EventHighlightsController::class, 'show'])->name('highlights.show');
    Route::post('/event-highlights/{id}/update', [EventHighlightsController::class, 'update'])->name('highlights.update');
    Route::delete('/event-highlights/{id}', [EventHighlightsController::class, 'destroy'])->name('highlights.destroy');

    Route::get('/logout', function () {
        Auth::logout(); // Logs out the current user
        request()->session()->invalidate(); // Invalidate session
        request()->session()->regenerateToken(); // Regenerate CSRF token

        return redirect('/'); // Redirect to homepage or login page
    })->name('logout');
});
