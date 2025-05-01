<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\Session;
use App\StudyProgram;
use App\WeekDay;
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

        $sessions = Session::orderBy('id')->get()->mapWithKeys(function ($session) {
            return [
                $session->id => \Carbon\Carbon::parse($session->start_time)->format('H:i') . ' - ' .
                    \Carbon\Carbon::parse($session->end_time)->format('H:i')
            ];
        })->toArray();

        $weekdays = Weekday::orderBy('id')->pluck('name', 'id')->toArray();

        $studyPrograms = StudyProgram::pluck('name', 'id');

        return view('admin.calendar', compact('weekDays', 'calendarData', 'classes', 'teachers', 'lessons', 'sessions', 'courses', 'weekdays', 'studyPrograms'));
    }

    public function clearLessons()
    {
        \App\Lesson::truncate(); // Reset semua lesson
        return redirect()->route('admin.calendar.index')->with('success', 'Semua lesson berhasil dihapus.');
    }
}