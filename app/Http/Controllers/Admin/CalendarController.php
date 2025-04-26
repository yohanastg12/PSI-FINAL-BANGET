<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lesson;
use App\Services\CalendarService;

class CalendarController extends Controller
{
    public function index(CalendarService $calendarService)
    {
        // Ambil hanya 7 hari (Monday - Sunday)
        $weekDays = array_slice(Lesson::WEEK_DAYS, 0, 7);

        // Generate calendar data
        $calendarData = $calendarService->generateCalendarData($weekDays);

        // PAKSA batasi data setiap sesi hanya untuk 7 hari
        foreach ($calendarData as $timeKey => $entries) {
            $calendarData[$timeKey] = array_slice($entries, 0, 7);
        }

        // Ambil daftar kelas dan guru
        $classes = \App\SchoolClass::pluck('name', 'id');
        $teachers = \App\User::whereHas('roles', function ($query) {
            $query->where('id', 3); // ID 3 = guru
        })->pluck('name', 'id');

        return view('admin.calendar', compact('weekDays', 'calendarData', 'classes', 'teachers'));
    }

    public function clearLessons()
    {
        \App\Lesson::truncate(); // Reset semua lesson
        return redirect()->route('admin.calendar.index')->with('success', 'Semua lesson berhasil dihapus.');
    }
}
