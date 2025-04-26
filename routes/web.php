<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\LessonsController;
use App\Http\Controllers\Admin\PreferenceController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Student\HomeController as StudentHomeController;

// Redirect ke login jika belum login
Route::redirect('/', '/login');

// Redirect setelah login
Route::get('/home', function () {
    $routeName = auth()->user() && (auth()->user()->is_student || auth()->user()->is_teacher) ? 'admin.calendar.index' : 'admin.home';
    if (session('status')) {
        return redirect()->route($routeName)->with('status', session('status'));
    }

    return redirect()->route($routeName);
});

// Nonaktifkan register
Auth::routes(['register' => false]);


// Route untuk ADMIN

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

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
    Route::post('/admin/lessons/store', [LessonsController::class, 'store'])->name('admin.lessons.store');

    // School Classes
    Route::delete('school-classes/destroy', 'SchoolClassesController@massDestroy')->name('school-classes.massDestroy');
    Route::resource('school-classes', 'SchoolClassesController');

    // Calendar
    Route::get('calendar', 'CalendarController@index')->name('calendar.index');
    Route::get('/calendar/lesson/{day}/{time}', [LessonsController::class, 'show'])->name('admin.calendar.show');
    Route::delete('/calendar/clear-lessons', [CalendarController::class, 'clearLessons'])->name('calendar.clear-lessons');
});


// Route untuk STUDENT

Route::middleware(['auth'])->group(function () {
    // Home Student
    Route::get('/student/home', [StudentHomeController::class, 'index'])->name('student.home');


// Ticketing Student

Route::get('/student/ticketing', [TicketController::class, 'index'])->name('student.ticketing.index');
Route::post('/student/ticketing', [TicketController::class, 'store'])->name('student.ticket.store');


});