<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\LessonsController;
use App\Http\Controllers\Admin\PreferenceController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\baa\BAAController;
use App\Http\Controllers\Student\TicketController as StudentTicketController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Student\HomeController as StudentHomeController;

// Redirect ke login jika belum login
Route::redirect('/', '/login');

// Redirect setelah login
Route::get('/home', function () {
    $user = auth()->user();
    $routeName = $user && ($user->is_student || $user->is_teacher)
        ? 'admin.calendar.index'
        : ($user->is_baa ? 'admin.calendar.index' : 'admin.home'); // <-- ubah di sini

    return redirect()->route($routeName)->with('status', session('status'));
});


// Nonaktifkan register
Auth::routes(['register' => false]);


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    // Ganti route '/' untuk mengarah ke dashboard
    Route::get('/', 'DashboardController@index')->name('home');  // Mengarah langsung ke DashboardController

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Lessons
    Route::delete('lessons/destroy', 'LessonsController@massDestroy')->name('lessons.massDestroy');
    Route::resource('lessons', 'LessonsController');
    Route::post('/lessons/store', 'LessonsController@store')->name('lessons.store');
    Route::post('/lessons/store', [LessonsController::class, 'store'])->name('admin.lessons.store');

    // School Classes
    Route::delete('school-classes/destroy', 'SchoolClassesController@massDestroy')->name('school-classes.massDestroy');
    Route::resource('school-classes', 'SchoolClassesController');

    // Study Program
    Route::get('study-program', 'StudyProgramController@index')->name('study-program.index');
    Route::delete('study-program/destroy', 'StudyProgramController@massDestroy')->name('study-program.massDestroy');
    Route::resource('study-program', 'StudyProgramController');

    // Course
    Route::get('course', 'CourseController@index')->name('course.index');
    Route::delete('course/destroy', 'CourseController@massDestroy')->name('course.massDestroy');
    Route::resource('course', 'CourseController');

    // Calendar
    Route::get('calendar', 'CalendarController@index')->name('calendar.index');
    Route::get('/calendar/lesson/{day}/{time}', [LessonsController::class, 'show'])->name('admin.calendar.show');
    Route::delete('/calendar/clear-lessons', [CalendarController::class, 'clearLessons'])->name('calendar.clear-lessons');

    // Room
    Route::get('room', 'RoomController@index')->name('room.index');
    Route::delete('room/destroy', 'RoomController@massDestroy')->name('room.massDestroy');
    Route::resource('room', 'RoomController');
});


// Route untuk STUDENT

Route::middleware(['auth'])->group(function () {
    // Home Student
Route::get('/student/home', [StudentHomeController::class, 'index'])->name('student.home');
Route::get('/ticket/create', [StudentTicketController::class, 'create'])->name('student.ticket.create');
Route::post('/ticket/store', [StudentTicketController::class, 'store'])->name('student.ticket.store');    
Route::get('/ticket/{id}/edit', [StudentTicketController::class, 'edit'])->name('ticket.edit');
Route::put('/ticket/{id}', [StudentTicketController::class, 'update'])->name('student.ticket.update');
Route::delete('/ticket/{id}', [StudentTicketController::class, 'destroy'])->name('student.ticket.destroy');
Route::get('/ticketing', [StudentTicketController::class, 'history'])->name('student.ticket.index');
Route::get('/ticket/{id}/edit', [StudentTicketController::class, 'edit'])->name('student.ticket.edit');

Route::get('/ticket/history', [StudentTicketController::class, 'history'])->name('student.ticket.history');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/baa/dashboard', [BAAController::class, 'index'])->name('baa.dashboard');
    Route::get('/baa/tickets', [BAAController::class, 'tickets'])->name('baa.tickets');
    Route::post('/baa/tickets/{id}/approve', [BAAController::class, 'approve'])->name('baa.tickets.approve');
Route::get('baa/ticket/{id}/reject', [BAAController::class, 'showRejectForm'])->name('baa.ticket.reject.form');
Route::post('baa/ticket/{id}/reject', [BAAController::class, 'reject'])->name('baa.ticket.reject');
});