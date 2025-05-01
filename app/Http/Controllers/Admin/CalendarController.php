<?php

namespace App\Http\Controllers\Admin;

use App\Course;
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

        $lessons = Lesson::all();
        $courses = Course::pluck('name', 'id');

        $sessions = [
            '1' => '08:00 - 08:50',
            '2' => '09:00 - 09:50',
            '3' => '10:00 - 10:50',
            '4' => '11:00 - 11:50',
            '5' => '12:00 - 12:50',
            '6' => '13:00 - 13:50',
            '7' => '14:00 - 14:50',
            '8' => '15:00 - 15:50',
            '9' => '16:00 - 16:50',
            '10' => '17:00 - 17:50',
        ];

        return view('admin.calendar', compact('weekDays', 'calendarData', 'classes', 'teachers', 'lessons', 'sessions', 'courses'));
    }

    public function clearLessons()
    {
        \App\Lesson::truncate(); // Reset semua lesson
        return redirect()->route('admin.calendar.index')->with('success', 'Semua lesson berhasil dihapus.');
    }
}